<?php

namespace App\Modules\Locations\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\Locations\Domain\Models\Location;
use App\Modules\Locations\Http\Requests\StoreLocationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class LocationController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $user = $this->user($request);
        $locations = Location::query()
            ->whereBelongsTo($user->organization)
            ->orderBy('name')
            ->get()
            ->map(fn (Location $location): array => $this->payload($location));

        return response()->json(['data' => $locations]);
    }

    public function store(StoreLocationRequest $request): JsonResponse
    {
        $user = $this->user($request);
        $location = $user->organization->locations()->create($request->safe()->only('name'));

        return response()->json(['data' => $this->payload($location)], 201);
    }

    public function show(Request $request, int $location): JsonResponse
    {
        $user = $this->user($request);
        $record = Location::query()
            ->whereBelongsTo($user->organization)
            ->findOrFail($location);

        return response()->json(['data' => $this->payload($record)]);
    }

    private function user(Request $request): User
    {
        /** @var User $user */
        $user = $request->user();
        $user->loadMissing('organization');

        return $user;
    }

    /** @return array{id: int, name: string} */
    private function payload(Location $location): array
    {
        return ['id' => $location->getKey(), 'name' => $location->name];
    }
}
