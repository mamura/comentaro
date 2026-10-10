<?php

namespace App\Modules\Connections\Infrastructure;

use App\Modules\Connections\Application\Contracts\IFoodGateway;
use App\Modules\Connections\Infrastructure\IFood\IFoodApiClient;
use Illuminate\Support\ServiceProvider;

final class ConnectionsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(IFoodGateway::class, IFoodApiClient::class);
    }
}
