<?php

use App\Modules\Connections\Domain\Enums\IntegrationStatus;
use App\Modules\Identity\Domain\Models\Organization;
use App\Modules\Interactions\Domain\Enums\InteractionPriority;
use App\Modules\Interactions\Domain\Enums\ProcessingStatus;
use App\Modules\Interactions\Domain\Enums\ReplyStatus;
use App\Modules\Locations\Domain\Models\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function interactionFor(string $organization, int $rating, string $externalId): array
{
    $user = Organization::query()->create(['name' => $organization])->user()->create([
        'name' => 'Responsável', 'email' => strtolower($organization).'@example.com', 'password' => 'senha-segura',
    ]);
    $user->markEmailAsVerified();
    $location = Location::query()->create(['organization_id' => $user->organization_id, 'name' => 'Unidade '.$organization]);
    $integration = $location->integrations()->create([
        'provider' => 'ifood', 'status' => IntegrationStatus::Active,
        'requested_identifier_type' => 'merchant_id', 'requested_identifier' => 'merchant-'.$organization,
        'merchant_id' => '550e8400-e29b-41d4-a716-'.str_pad((string) $user->id, 12, '0', STR_PAD_LEFT), 'sync_interval_minutes' => 60,
    ]);
    $interaction = $integration->interactions()->create([
        'external_id' => $externalId, 'rating' => $rating, 'comment' => 'Comentário '.$organization,
        'occurred_at' => now(), 'priority' => InteractionPriority::fromRating($rating),
        'processing_status' => ProcessingStatus::Received, 'reply_status' => ReplyStatus::NotReplied,
    ]);

    return [$user, $interaction];
}

it('lists interactions with priority derived from the rating', function () {
    [$user, $interaction] = interactionFor('A', 2, 'review-a');

    $this->actingAs($user)->getJson('/api/v1/interactions')->assertOk()
        ->assertJsonCount(1, 'data')->assertJsonPath('data.0.id', $interaction->id)
        ->assertJsonPath('data.0.priority', 'high')->assertJsonPath('data.0.location.name', 'Unidade A');
});

it('does not expose interactions from another organization', function () {
    [$user] = interactionFor('A', 5, 'review-a');
    [, $otherInteraction] = interactionFor('B', 1, 'review-b');

    $this->actingAs($user)->getJson('/api/v1/interactions')->assertOk()->assertJsonCount(1, 'data')
        ->assertJsonMissing(['external_id' => 'review-b']);
    $this->getJson('/api/v1/interactions/'.$otherInteraction->id)->assertNotFound();
});

it('maps every accepted rating to its fixed priority', function (int $rating, InteractionPriority $priority) {
    expect(InteractionPriority::fromRating($rating))->toBe($priority);
})->with([
    [1, InteractionPriority::High], [2, InteractionPriority::High], [3, InteractionPriority::Medium],
    [4, InteractionPriority::Low], [5, InteractionPriority::Low],
]);
