<?php

namespace App\Console\Commands;

use App\Modules\Connections\Application\ConfirmIFoodAccessRequest;
use App\Modules\Connections\Domain\Models\Integration;
use Illuminate\Console\Command;

final class ConfirmIFoodAccessRequestCommand extends Command
{
    protected $signature = 'ifood:confirm-access-request {integration} {merchantId}';

    protected $description = 'Registra que o acesso foi solicitado manualmente no portal do iFood';

    public function handle(ConfirmIFoodAccessRequest $action): int
    {
        $integration = Integration::query()->findOrFail((int) $this->argument('integration'));
        $action->handle($integration, (string) $this->argument('merchantId'));
        $this->info('Solicitação registrada; a integração aguarda aprovação no iFood.');

        return self::SUCCESS;
    }
}
