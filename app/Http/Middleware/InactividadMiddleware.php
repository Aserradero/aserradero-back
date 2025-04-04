<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class InactividadMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            // Verificar el tiempo de la última actividad desde la sesión
            $lastActivity = session('last_activity_time', Carbon::now());

            // Establecer el límite de inactividad en minutos (por ejemplo, 1 minuto)
            $inactivityTime = Carbon::now()->diffInMinutes($lastActivity);

            if ($inactivityTime > 1) {
                // Si se excede el tiempo de inactividad, cerrar sesión
                Auth::logout();
                session()->invalidate();
                session()->regenerateToken();
                return response()->json(['message' => 'Sesión expirada por inactividad'], 401);
            }

            // Actualizar el tiempo de la última actividad solo cuando la sesión está activa
            session(['last_activity_time' => Carbon::now()]);
        }

        return $next($request);
    }
}
