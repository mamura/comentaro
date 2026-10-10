<?php

namespace App\Modules\Connections\Application;

use App\Modules\Connections\Domain\Enums\IntegrationStatus;
use App\Modules\Connections\Domain\Models\Integration;
use DomainException;
use Illuminate\Support\Str;

final class ConfirmIFoodAccessRequest
{
    public function handle(Integration $integration, string $merchantId): Integration
    {
        if (! Str::isUuid($merchantId)) {
            throw new DomainException('O merchantId do iFood precisa ser um UUID válido.');
        }

        if ($integration->provider !== 'ifood' || $integration->status !== IntegrationStatus::Draft) {
            throw new DomainException('A integração precisa ser um rascunho iFood.');
        }

        $integration->update([
            'merchant_id' => $merchantId,
            'status' => IntegrationStatus::AwaitingApproval,
        ]);

        return $integration->refresh();
    }
}
