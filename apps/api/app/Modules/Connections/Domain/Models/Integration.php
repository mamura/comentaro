<?php

namespace App\Modules\Connections\Domain\Models;

use App\Modules\Connections\Domain\Enums\IntegrationStatus;
use App\Modules\Locations\Domain\Models\Location;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** @property IntegrationStatus $status */
#[Fillable(['location_id', 'provider', 'status', 'requested_identifier_type', 'requested_identifier', 'merchant_id', 'sync_interval_minutes'])]
class Integration extends Model
{
    /** @return BelongsTo<Location, $this> */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    /** @return array<string, string> */
    protected function casts(): array
    {
        return ['status' => IntegrationStatus::class];
    }
}
