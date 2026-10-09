<?php

use App\Models\User;
use App\Modules\Identity\Domain\Models\Organization;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    $this->withHeader('Origin', config('app.frontend_url'));
});

it('registers a user and organization atomically and requests email verification', function () {
    Notification::fake();

    $response = $this->postJson('/api/v1/auth/register', [
        'name' => 'Maria Silva',
        'organization_name' => 'Restaurante Maria',
        'email' => 'maria@example.com',
        'password' => 'senha-segura',
        'password_confirmation' => 'senha-segura',
    ]);

    $response->assertCreated()
        ->assertJsonPath('user.organization.name', 'Restaurante Maria')
        ->assertJsonPath('user.email_verified', false);
    $this->assertDatabaseHas('organizations', ['name' => 'Restaurante Maria']);
    $this->assertDatabaseHas('users', ['email' => 'maria@example.com']);
    Notification::assertSentTo(User::query()->firstOrFail(), VerifyEmail::class);
    $this->assertAuthenticated();
});

it('rejects short passwords without leaving partial records', function () {
    $this->postJson('/api/v1/auth/register', [
        'name' => 'Maria Silva',
        'organization_name' => 'Restaurante Maria',
        'email' => 'maria@example.com',
        'password' => 'curta',
        'password_confirmation' => 'curta',
    ])->assertUnprocessable();

    expect(User::query()->count())->toBe(0)
        ->and(Organization::query()->count())->toBe(0);
});

it('logs in and returns only the organization linked to the session', function () {
    $organization = Organization::query()->create(['name' => 'Organização A']);
    $user = $organization->user()->create([
        'name' => 'Ana', 'email' => 'ana@example.com', 'password' => 'senha-segura',
    ]);

    $this->postJson('/api/v1/auth/login', [
        'email' => 'ana@example.com', 'password' => 'senha-segura', 'remember' => true,
    ])->assertOk()->assertJsonPath('user.organization.id', $organization->getKey());

    $this->getJson('/api/v1/auth/user')
        ->assertOk()
        ->assertJsonMissing(['organization_id' => 999]);
    $this->assertAuthenticatedAs($user);
});

it('verifies an email once using a signed link', function () {
    $user = Organization::query()->create(['name' => 'Organização A'])->user()->create([
        'name' => 'Ana', 'email' => 'ana@example.com', 'password' => 'senha-segura',
    ]);
    $url = URL::temporarySignedRoute('verification.verify', now()->addHour(), [
        'id' => $user->getKey(), 'hash' => sha1($user->getEmailForVerification()),
    ]);

    $this->get($url)->assertRedirect(config('app.frontend_url').'/login?email_verified=1');
    expect($user->fresh()->hasVerifiedEmail())->toBeTrue();
});

it('returns a neutral recovery response and can reset the password once', function () {
    Notification::fake();
    $user = Organization::query()->create(['name' => 'Organização A'])->user()->create([
        'name' => 'Ana', 'email' => 'ana@example.com', 'password' => 'senha-segura',
    ]);

    $this->postJson('/api/v1/auth/forgot-password', ['email' => 'ana@example.com'])
        ->assertOk()->assertJsonMissing(['exists' => true]);
    Notification::assertSentTo($user, ResetPassword::class, function (ResetPassword $notification) use ($user): bool {
        $this->postJson('/api/v1/auth/reset-password', [
            'email' => $user->email,
            'token' => $notification->token,
            'password' => 'nova-senha-segura',
            'password_confirmation' => 'nova-senha-segura',
        ])->assertOk();

        return true;
    });

    expect(Hash::check('nova-senha-segura', $user->fresh()->password))->toBeTrue();
});

it('logs out the current session', function () {
    $user = Organization::query()->create(['name' => 'Organização A'])->user()->create([
        'name' => 'Ana', 'email' => 'ana@example.com', 'password' => 'senha-segura',
    ]);

    $this->postJson('/api/v1/auth/login', [
        'email' => $user->email,
        'password' => 'senha-segura',
    ])->assertOk();

    $this->postJson('/api/v1/auth/logout')->assertOk();
    $this->getJson('/api/v1/auth/user')->assertUnauthorized();
});
