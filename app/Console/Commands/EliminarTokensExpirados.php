<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Laravel\Sanctum\PersonalAccessToken;

class EliminarTokensExpirados extends Command
{
    protected $signature = 'tokens:limpiar-expirados';
    protected $description = 'Elimina tokens de Sanctum que ya han expirado (expires_at < now)';

    public function handle()
    {
        $cantidad = PersonalAccessToken::whereNotNull('expires_at')
            ->where('expires_at', '<', now())
            ->delete();

        $this->info("Se eliminaron $cantidad tokens expirados.");
        \Log::info("⏰ Se ejecutó limpieza automática de tokens a " . now());
    }
}
