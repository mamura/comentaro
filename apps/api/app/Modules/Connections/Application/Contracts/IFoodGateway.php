<?php

namespace App\Modules\Connections\Application\Contracts;

interface IFoodGateway
{
    public function canAccessMerchant(string $merchantId): bool;
}
