<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Log;


class DeleteExpiredTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-expired-tokens';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        /*
        $count = PersonalAccessToken::where('expires_at', '<', now())->delete();

        if ($count > 0) {
            $this->info("Se eliminaron $count tokens expirados.");
            Log::info("Se eliminaron $count tokens expirados desde el comando.");
        } else {
            $this->info("No hay tokens expirados para eliminar.");
        }

        return 0;
        */

    }
}
