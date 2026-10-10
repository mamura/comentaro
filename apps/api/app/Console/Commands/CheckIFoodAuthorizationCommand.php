<?php

namespace App\Console\Commands;

use App\Modules\Connections\Application\CheckIFoodAuthorization;
use App\Modules\Connections\Domain\Models\Integration;
use Illuminate\Console\Command;

final class CheckIFoodAuthorizationCommand extends Command
{
    protected $signature = 'ifood:check-authorization {integration}';

    protected $description = 'Verifica na Merchant API se uma loja aprovou o acesso';

    public function handle(CheckIFoodAuthorization $action): int
    {
        $integration = Integration::query()->findOrFail((int) $this->argument('integration'));

        if (! $action->handle($integration)) {
            $this->warn('A loja ainda não está autorizada para a aplicação iFood.');

            return self::SUCCESS;
        }

        $this->info('Autorização confirmada; a integração está pronta para a carga inicial.');

        return self::SUCCESS;
    }
}
