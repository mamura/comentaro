<?php

use App\Models\User;
use App\Modules\Identity\Domain\Models\Organization;
use App\Modules\Locations\Domain\Models\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function verifiedUser(string $organizationName): User
{
    $user = Organization::query()->create(['name' => $organizationName])->user()->create([
        'name' => 'Responsável',
        'email' => strtolower(str_replace(' ', '-', $organizationName)).'@example.com',
        'password' => 'senha-segura',
    ]);
    $user->markEmailAsVerified();

    return $user;
}

it('creates and lists locations inside the authenticated organization', function () {
    $user = verifiedUser('Organização A');
    Location::query()->create(['organization_id' => $user->organization_id, 'name' => 'Unidade Centro']);
    Location::query()->create([
        'organization_id' => verifiedUser('Organização B')->organization_id,
        'name' => 'Unidade de outro cliente',
    ]);

    $this->actingAs($user)->postJson('/api/v1/locations', [
        'name' => 'Unidade Norte',
    ])->assertCreated()->assertJsonPath('data.name', 'Unidade Norte');

    $this->getJson('/api/v1/locations')
        ->assertOk()
        ->assertJsonCount(2, 'data')
        ->assertJsonMissing(['name' => 'Unidade de outro cliente']);
});

it('does not accept an organization selected by the client', function () {
    $user = verifiedUser('Organização A');
    $other = verifiedUser('Organização B');

    $this->actingAs($user)->postJson('/api/v1/locations', [
        'name' => 'Tentativa',
        'organization_id' => $other->organization_id,
    ])->assertUnprocessable();

    $this->assertDatabaseMissing('locations', ['name' => 'Tentativa']);
});

it('returns not found for a location from another organization', function () {
    $user = verifiedUser('Organização A');
    $other = verifiedUser('Organização B');
    $location = Location::query()->create([
        'organization_id' => $other->organization_id,
        'name' => 'Unidade privada',
    ]);

    $this->actingAs($user)->getJson('/api/v1/locations/'.$location->getKey())->assertNotFound();
});

it('requires a verified email for location operations', function () {
    $user = Organization::query()->create(['name' => 'Organização A'])->user()->create([
        'name' => 'Responsável', 'email' => 'user@example.com', 'password' => 'senha-segura',
    ]);

    $this->actingAs($user)->getJson('/api/v1/locations')->assertForbidden();
});
