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
        // Obtener el token desde el encabezado de autorización
        $authHeader = $request->header('Authorization');

        if ($authHeader) {
            // Extraer el token del encabezado
            $tokenId = trim(str_replace('Bearer ', '', $authHeader));

            // Buscar el token en la base de datos
            $token = PersonalAccessToken::findToken($tokenId);

            if ($token) {
                // Tiempo de expiración en minutos desde la última actividad
                $expirationMinutes = config('sanctum.expiration'); // Puedes ajustar el tiempo

                // Verificar si el token ha caducado (comparando con last_used_at o created_at)
                $lastActivity = $token->last_used_at ?? $token->created_at;
                if (Carbon::parse($lastActivity)->addMinutes($expirationMinutes)->isPast()) {
                    // Eliminar el token caducado
                    $token->delete();
                    return response()->json(['message' => 'Token expirado, inicie sesión nuevamente'], 401);
                }

                // Actualizar el tiempo de última actividad del token
                $token->forceFill(['last_used_at' => now()])->save();

                // Autenticar al usuario manualmente
                $user = $token->tokenable;
                Auth::login($user);

                // Dejar continuar la solicitud si el token sigue activo
                return $next($request);
            }

            // El token no está en la base de datos
            return response()->json(['message' => 'Token no encontrado o ya eliminado'], 401);
        }

        // No se encontró el encabezado de autorización
        return response()->json(['message' => 'No se encontró el token en la solicitud'], 401);


    }
}
