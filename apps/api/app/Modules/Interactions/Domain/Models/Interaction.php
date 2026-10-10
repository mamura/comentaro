<?php

namespace App\Modules\Interactions\Domain\Models;

use App\Modules\Connections\Domain\Models\Integration;
use App\Modules\Interactions\Domain\Enums\InteractionPriority;
use App\Modules\Interactions\Domain\Enums\ProcessingStatus;
use App\Modules\Interactions\Domain\Enums\ReplyStatus;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property InteractionPriority $priority
 * @property ProcessingStatus $processing_status
 * @property ReplyStatus $reply_status
 * @property CarbonImmutable $occurred_at
 */
#[Fillable(['integration_id', 'external_id', 'rating', 'comment', 'occurred_at', 'priority', 'processing_status', 'reply_status', 'provider_status', 'visibility', 'provider_version', 'raw_payload'])]
class Interaction extends Model
{
    /** @return BelongsTo<Integration, $this> */
    public function integration(): BelongsTo
    {
        return $this->belongsTo(Integration::class);
    }

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'priority' => InteractionPriority::class,
            'processing_status' => ProcessingStatus::class,
            'reply_status' => ReplyStatus::class,
            'occurred_at' => 'immutable_datetime',
            'raw_payload' => 'encrypted:array',
        ];
    }
}
