<?php

use App\Modules\Connections\Domain\Enums\IntegrationStatus;
use App\Modules\Connections\Domain\Models\Integration;
use App\Modules\Identity\Domain\Models\Organization;
use App\Modules\Locations\Domain\Models\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

uses(RefreshDatabase::class);

function draftIFoodIntegration(): Integration
{
    $user = Organization::query()->create(['name' => 'Organização A'])->user()->create([
        'name' => 'Responsável', 'email' => 'owner@example.com', 'password' => 'senha-segura',
    ]);
    $location = Location::query()->create(['organization_id' => $user->organization_id, 'name' => 'Unidade Centro']);

    return $location->integrations()->create([
        'provider' => 'ifood', 'status' => IntegrationStatus::Draft,
        'requested_identifier_type' => 'cnpj', 'requested_identifier' => '12345678000190',
        'sync_interval_minutes' => 60,
    ]);
}

it('records a portal access request with its confirmed merchant id', function () {
    $integration = draftIFoodIntegration();

    $this->artisan('ifood:confirm-access-request', ['integration' => $integration->id, 'merchantId' => '550e8400-e29b-41d4-a716-446655440000'])
        ->assertSuccessful();

    expect($integration->refresh()->status)->toBe(IntegrationStatus::AwaitingApproval)
        ->and($integration->merchant_id)->toBe('550e8400-e29b-41d4-a716-446655440000');
});

it('confirms an approved merchant through client credentials', function () {
    $integration = draftIFoodIntegration();
    $this->artisan('ifood:confirm-access-request', ['integration' => $integration->id, 'merchantId' => '550e8400-e29b-41d4-a716-446655440000']);
    config()->set('services.ifood.client_id', 'client-id');
    config()->set('services.ifood.client_secret', 'client-secret');
    Cache::clear();
    Http::fake([
        '*/authentication/v1.0/oauth/token' => Http::response(['accessToken' => 'secret-token', 'expiresIn' => 21600]),
        '*/merchant/v1.0/merchants/550e8400-e29b-41d4-a716-446655440000' => Http::response(['id' => '550e8400-e29b-41d4-a716-446655440000', 'name' => 'Unidade Centro']),
    ]);

    $this->artisan('ifood:check-authorization', ['integration' => $integration->id])->assertSuccessful();

    expect($integration->refresh()->status)->toBe(IntegrationStatus::Activating);
    Http::assertSentCount(2);
    Http::assertSent(fn ($request) => $request->url() === 'https://merchant-api.ifood.com.br/authentication/v1.0/oauth/token'
        && $request['grantType'] === 'client_credentials'
        && $request['clientSecret'] === 'client-secret');
    Http::assertSent(fn ($request) => $request->url() === 'https://merchant-api.ifood.com.br/merchant/v1.0/merchants/550e8400-e29b-41d4-a716-446655440000'
        && $request->hasHeader('Authorization', 'Bearer secret-token'));
});

it('keeps waiting when the merchant has not authorized access', function () {
    $integration = draftIFoodIntegration();
    $this->artisan('ifood:confirm-access-request', ['integration' => $integration->id, 'merchantId' => '550e8400-e29b-41d4-a716-446655440000']);
    config()->set('services.ifood.client_id', 'client-id');
    config()->set('services.ifood.client_secret', 'client-secret');
    Cache::clear();
    Http::fake([
        '*/authentication/v1.0/oauth/token' => Http::response(['accessToken' => 'secret-token', 'expiresIn' => 21600]),
        '*/merchant/v1.0/merchants/550e8400-e29b-41d4-a716-446655440000' => Http::response(['code' => 'Forbidden'], 403),
    ]);

    $this->artisan('ifood:check-authorization', ['integration' => $integration->id])->assertSuccessful();

    expect($integration->refresh()->status)->toBe(IntegrationStatus::AwaitingApproval);
});
