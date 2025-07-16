<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;


class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notificaciones = Notification::all();

        return $notificaciones;
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'calidad' => 'required|string|max:255',
            'ancho' => 'required|numeric',
            'grosor' => 'required|numeric',
            'largo' => 'required|numeric',
            'piesTabla' => 'required|numeric',
            'activo' => 'boolean',
            'stockIdealPT' => 'required|numeric',
            'image' => 'string | max:255',
            'stockActual' => 'numeric'
        ]);

        $notificacionExistente = Notification::where('calidad', $validated['calidad'])
            ->where('ancho', $validated['ancho'])
            ->where('grosor', $validated['grosor'])
            ->where('largo', $validated['largo'])
            ->where('activo', true)
            ->first();

        // Si ya hay suficiente stock, eliminar la notificación si existe
        if ($validated['stockIdealPT'] <= $validated['piesTabla']) {
            if ($notificacionExistente) {
                $notificacionExistente->delete(); // o ->update(['activo' => false])
                return response()->json([
                    'message' => 'Notificación eliminada porque el stock es suficiente.',
                ], 200);
            }

            return response()->json([
                'message' => 'No se requiere notificación. Stock suficiente.',
            ], 200);
        }

        // Si ya hay una notificación activa, actualizar si cambió alguna parte
        if ($notificacionExistente) {
            $actualizar = false;
            $camposActualizar = [];

            if ($notificacionExistente->piesTabla != $validated['piesTabla']) {
                $camposActualizar['piesTabla'] = $validated['piesTabla'];
                $actualizar = true;
            }

            if ($notificacionExistente->stockIdealPT != $validated['stockIdealPT']) {
                $camposActualizar['stockIdealPT'] = $validated['stockIdealPT'];
                $actualizar = true;
            }

            if ($notificacionExistente->stockActual != $validated['stockActual']) {
                $camposActualizar['stockActual'] = $validated['stockActual'];
                $actualizar = true;
            }

            if ($actualizar) {
                $notificacionExistente->update($camposActualizar);
                return response()->json([
                    'message' => 'Notificación actualizada con nuevos valores.',
                    'data' => $notificacionExistente
                ], 200);
            }

            return response()->json([
                'message' => 'No se detectaron cambios.',
                'data' => $notificacionExistente
            ], 200);
        }


        // Crear nueva notificación si no existe
        $notification = Notification::create($validated);

        return response()->json([
            'message' => 'Notificación creada exitosamente',
            'data' => $notification
        ], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
