<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductionHistory;
use Illuminate\Http\Request;

class ProductionHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Obtenemos todo el historial de produccion
        $productions = ProductionHistory::all();
        return response()->json([
            "message" => "Historial de produccion",
            "productions" => $productions
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeMultiple(Request $request)
    {
        // Puedes agregar validaciones aquí si lo deseas (opcional)

        $nuevoProduction = new ProductionHistory();

        $nuevoProduction->coeficiente = $request->input('coeficiente');
        $nuevoProduction->m3TRM = $request->input('m3TRM');
        $nuevoProduction->piesTablaTP = $request->input('piesTablaTP');
        $nuevoProduction->fechaFinalizacion = $request->input('fechaFinalizacion');
        $nuevoProduction->identificadorP = $request->input('identificadorP');
        $nuevoProduction->user_id = $request->input('user_id');

        $nuevoProduction->save();

        return response()->json([
            "message" => "Materia registrada correctamente.",
            "material" => $nuevoProduction
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
    public function update(Request $request, string $identificadorP)
    {
        // Buscar por identificadorP, no por id
        $production = ProductionHistory::where('identificadorP', $identificadorP)->first();

        if (!$production) {
            return response()->json([
                'message' => 'Producción no encontrada',
            ], 404);
        }

        //atributos del historial de produccion 
        $production->coeficiente = $request->input('coeficiente');
        //$production->m3TRM = $request->input('m3TRM');
        $production->piesTablaTP = $request->input('piesTablaTP');
        $production->fechaFinalizacion = $request->input('fechaFinalizacion');
        //$production->identificadorP = $request->input('identificadorP');
        //$production->user_id = $request->input('user_id');
        $production->update($request->all());
        // Retornar respuesta JSON
        return response()->json([
            'message' => 'Historial de produccion actualizado correctamente',
            'production' => $production
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function updateStatus(Request $request, string $identificadorP)
    {
        $production = ProductionHistory::where('identificadorP', $identificadorP)->first();


        // Actualizar el estatus
        $production->estatus = $request->input('estatus');
        $production->save();

        return response()->json([
            'message' => 'Estatus actualizado correctamente',
            'production' => $production
        ], 200);
    }

    public function updateDatos(Request $request, string $identificadorP)
    {
        $production = ProductionHistory::where('identificadorP', $identificadorP)->first();

        if (!$production) {
            return response()->json(['message' => 'Producción no encontrada'], 404);
        }

        // Actualizar el estatus
        $production->coeficiente = $request->input('coeficiente');
        $production->piesTablaTP = $request->input('piesTablaTP');
        $production->fechaFinalizacion = $request->input('fechaFinalizacion');
        $production->save();

        return response()->json([
            'message' => 'Estatus actualizado correctamente',
            'production' => $production
        ], 200);
    }
}
