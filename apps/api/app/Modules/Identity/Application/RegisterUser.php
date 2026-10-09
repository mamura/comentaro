<?php

namespace App\Modules\Identity\Application;

use App\Models\User;
use App\Modules\Identity\Domain\Models\Organization;
use Illuminate\Support\Facades\DB;

final class RegisterUser
{
    /** @param array{name: string, email: string, password: string, organization_name: string} $data */
    public function handle(array $data): User
    {
        return DB::transaction(function () use ($data): User {
            $organization = Organization::query()->create([
                'name' => $data['organization_name'],
            ]);

            return $organization->user()->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
            ]);
        });
    }
}
