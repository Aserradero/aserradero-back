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
        if (!$request->has('productionHistories') || !is_array($request->productionHistories)) {
            return response()->json(["error" => "El formato de los datos es incorrecto. Se espera un array de materia."], 400);
        }

        $productionH = $request->productionHistories; // Obtener el array de productos
        $productionHG = [];

        foreach ($productionH as $production) {
            // Crear una nueva instancia de Product
            $nuevoProduction = new ProductionHistory();

            // Asignar valores
            $nuevoProduction->coeficiente = $production['coeficiente'];
            $nuevoProduction->m3TRM = $production['m3TRM'];
            $nuevoProduction->piesTablaTP = $production['piesTablaTP'];
            $nuevoProduction->fechaFinalizacion = $production['fechaFinalizacion'];
            $nuevoProduction->identificadorP = $production['identificadorP'];
            $nuevoProduction->user_id = $production['user_id'];


            // Guardar en la base de datos
            $nuevoProduction->save();

            // Agregar el producto guardado a la lista de respuesta
            $productosHG[] = $nuevoProduction;
        }

        return response()->json(["message" => "Materiax registradas correctamente.", "materials" => $productosHG], 201);
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
