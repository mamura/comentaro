<?php

namespace App\Modules\Connections\Application;

use App\Modules\Connections\Application\Contracts\IFoodGateway;
use App\Modules\Connections\Domain\Enums\IntegrationStatus;
use App\Modules\Connections\Domain\Models\Integration;
use DomainException;

final class CheckIFoodAuthorization
{
    public function __construct(private readonly IFoodGateway $gateway) {}

    public function handle(Integration $integration): bool
    {
        if ($integration->provider !== 'ifood' || $integration->status !== IntegrationStatus::AwaitingApproval) {
            throw new DomainException('A integração precisa estar aguardando aprovação do iFood.');
        }

        if ($integration->merchant_id === null || ! $this->gateway->canAccessMerchant($integration->merchant_id)) {
            return false;
        }

        $integration->update(['status' => IntegrationStatus::Activating]);

        return true;
    }
}
