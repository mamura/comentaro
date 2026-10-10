<?php

namespace App\Modules\Interactions\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\Interactions\Domain\Models\Interaction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class InteractionController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $interactions = $this->query($request)->latest('occurred_at')->limit(100)->get();

        return response()->json(['data' => $interactions->map(fn (Interaction $interaction): array => $this->payload($interaction))]);
    }

    public function show(Request $request, int $interaction): JsonResponse
    {
        return response()->json(['data' => $this->payload($this->query($request)->findOrFail($interaction))]);
    }

    /** @return Builder<Interaction> */
    private function query(Request $request): Builder
    {
        /** @var User $user */
        $user = $request->user();

        return Interaction::query()
            ->with('integration.location')
            ->whereHas('integration.location', fn (Builder $query) => $query->where('organization_id', $user->organization_id));
    }

    /** @return array<string, mixed> */
    private function payload(Interaction $interaction): array
    {
        return [
            'id' => $interaction->getKey(),
            'location' => ['id' => $interaction->integration->location->getKey(), 'name' => $interaction->integration->location->name],
            'provider' => $interaction->integration->provider,
            'external_id' => $interaction->external_id,
            'rating' => $interaction->rating,
            'comment' => $interaction->comment,
            'occurred_at' => $interaction->occurred_at->toIso8601String(),
            'priority' => $interaction->priority->value,
            'processing_status' => $interaction->processing_status->value,
            'reply_status' => $interaction->reply_status->value,
        ];
    }
}
