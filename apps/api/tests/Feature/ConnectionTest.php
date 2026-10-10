<?php

use App\Models\User;
use App\Modules\Identity\Domain\Models\Organization;
use App\Modules\Locations\Domain\Models\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function connectionOwner(string $suffix): User
{
    $user = Organization::query()->create(['name' => 'Organização '.$suffix])->user()->create([
        'name' => 'Responsável', 'email' => 'owner-'.$suffix.'@example.com', 'password' => 'senha-segura',
    ]);
    $user->markEmailAsVerified();

    return $user;
}

it('creates one draft iFood connection and returns it on repetition', function () {
    $user = connectionOwner('A');
    $location = Location::query()->create(['organization_id' => $user->organization_id, 'name' => 'Unidade Centro']);
    $payload = ['identifier_type' => 'cnpj', 'identifier' => '12.345.678/0001-90'];

    $this->actingAs($user)->postJson("/api/v1/locations/{$location->id}/connections/ifood", $payload)
        ->assertCreated()->assertJsonPath('data.status', 'draft')->assertJsonPath('data.requested_identifier', '12345678000190');
    $this->postJson("/api/v1/locations/{$location->id}/connections/ifood", $payload)->assertOk();
    $this->assertDatabaseCount('integrations', 1);
});

it('rejects changing the identifier of an existing request', function () {
    $user = connectionOwner('A');
    $location = Location::query()->create(['organization_id' => $user->organization_id, 'name' => 'Unidade Centro']);
    $this->actingAs($user)->postJson("/api/v1/locations/{$location->id}/connections/ifood", ['identifier_type' => 'merchant_id', 'identifier' => 'merchant-a'])->assertCreated();
    $this->postJson("/api/v1/locations/{$location->id}/connections/ifood", ['identifier_type' => 'merchant_id', 'identifier' => 'merchant-b'])->assertUnprocessable();
    $this->assertDatabaseCount('integrations', 1);
});

it('does not expose or connect a location from another organization', function () {
    $user = connectionOwner('A');
    $other = connectionOwner('B');
    $location = Location::query()->create(['organization_id' => $other->organization_id, 'name' => 'Unidade privada']);

    $this->actingAs($user)->getJson("/api/v1/locations/{$location->id}/connections")->assertNotFound();
    $this->postJson("/api/v1/locations/{$location->id}/connections/ifood", ['identifier_type' => 'merchant_id', 'identifier' => 'merchant-a'])->assertNotFound();
    $this->assertDatabaseCount('integrations', 0);
});
