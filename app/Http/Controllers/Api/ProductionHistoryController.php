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
        //
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
