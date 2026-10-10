<?php

namespace App\Modules\Connections\Application;

use App\Modules\Connections\Domain\Enums\IntegrationStatus;
use App\Modules\Connections\Domain\Models\Integration;
use App\Modules\Locations\Domain\Models\Location;
use Illuminate\Validation\ValidationException;

final class RequestIFoodConnection
{
    public function handle(Location $location, string $identifierType, string $identifier): Integration
    {
        $existing = $location->integrations()->where('provider', 'ifood')->first();

        if ($existing !== null) {
            if ($existing->requested_identifier_type !== $identifierType || $existing->requested_identifier !== $identifier) {
                throw ValidationException::withMessages([
                    'identifier' => ['Esta unidade já possui uma solicitação iFood com outro identificador.'],
                ]);
            }

            return $existing;
        }

        return $location->integrations()->create([
            'provider' => 'ifood',
            'status' => IntegrationStatus::Draft,
            'requested_identifier_type' => $identifierType,
            'requested_identifier' => $identifier,
            'sync_interval_minutes' => 60,
        ]);
    }
}
