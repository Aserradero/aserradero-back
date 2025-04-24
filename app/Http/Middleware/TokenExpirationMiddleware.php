<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Sanctum\PersonalAccessToken;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class TokenExpirationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // Limpiar tokens expirados
        $count = PersonalAccessToken::where('expires_at', '<', now())->delete();
        if ($count > 0) {
            Log::info("Se eliminaron $count tokens expirados.");
        }

        // Verificar si el token está presente en la cabecera Authorization
        $tokenString = $request->bearerToken();
        if (!$tokenString) {
            return response()->json(['message' => 'Token no proporcionado.'], 401);
        }

        // Buscar el token en la base de datos
        $token = PersonalAccessToken::findToken($tokenString);
        if (!$token) {
            return response()->json(['message' => 'Token inválido.'], 401);
        }

        // Validar si el token ya expiró
        if ($token->expires_at && $token->expires_at->isPast()) {
            $token->delete(); // Elimina el token expirado
            return response()->json(['message' => 'Token expirado.'], 401);
        }

        // Token válido
        return $next($request);

    }
}
