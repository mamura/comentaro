<?php

namespace App\Modules\Connections\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\Connections\Application\RequestIFoodConnection;
use App\Modules\Connections\Domain\Models\Integration;
use App\Modules\Connections\Http\Requests\RequestIFoodConnectionRequest;
use App\Modules\Locations\Domain\Models\Location;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class ConnectionController extends Controller
{
    public function index(Request $request, int $location): JsonResponse
    {
        $record = $this->location($request, $location);
        $integrations = $record->integrations()->orderBy('provider')->get()
            ->map(fn (Integration $integration): array => $this->payload($integration));

        return response()->json(['data' => $integrations]);
    }

    public function store(
        RequestIFoodConnectionRequest $request,
        int $location,
        RequestIFoodConnection $requestConnection,
    ): JsonResponse {
        $record = $this->location($request, $location);
        $data = $request->validated();
        $integration = $requestConnection->handle($record, $data['identifier_type'], $data['identifier']);

        return response()->json(
            ['data' => $this->payload($integration)],
            $integration->wasRecentlyCreated ? 201 : 200,
        );
    }

    private function location(Request $request, int $location): Location
    {
        /** @var User $user */
        $user = $request->user();
        $user->loadMissing('organization');

        return Location::query()->whereBelongsTo($user->organization)->findOrFail($location);
    }

    /** @return array<string, mixed> */
    private function payload(Integration $integration): array
    {
        return [
            'id' => $integration->getKey(),
            'provider' => $integration->provider,
            'status' => $integration->status->value,
            'requested_identifier_type' => $integration->requested_identifier_type,
            'requested_identifier' => $integration->requested_identifier,
            'merchant_id' => $integration->merchant_id,
            'sync_interval_minutes' => $integration->sync_interval_minutes,
        ];
    }
}
