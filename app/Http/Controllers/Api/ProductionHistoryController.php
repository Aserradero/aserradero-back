<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductionHistory;
use App\Models\RawMaterial;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;


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
        try {
            // Verifica si ya existe
            $existe = ProductionHistory::where('identificadorP', $request->input('identificadorP'))->exists();

            if ($existe) {
                return response()->json([
                    "message" => "Ya existe un registro con ese identificador.",
                    "error" => true
                ], 409);
            }

            // Intenta guardar
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

        } catch (QueryException $e) {
            // Captura duplicado por restricción única
            if ($e->errorInfo[1] == 1062) { // Código MySQL para entrada duplicada
                return response()->json([
                    "message" => "Este identificador ya fue registrado por otro usuario.",
                    "error" => true
                ], 409);
            }

            // Otros errores
            return response()->json([
                "message" => "Error inesperado al registrar la producción.",
                "error" => $e->getMessage()
            ], 500);
        }
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

    public function updateDatos(Request $request)
    {
        // Verificar que la solicitud contenga el array 'productos'
        if (!$request->has('productos') || !is_array($request->productos)) {
            return response()->json(["error" => "El formato de los datos es incorrecto. Se espera un array de productos."], 400);
        }

        $productos = $request->productos; // Obtener el array de productos

        //obtener al producto 
        foreach ($productos as $producto) {
            $identificadorP = $producto['identificadorP'];
            //buscar a la produccion que pertenece el producto
            $production = ProductionHistory::where('identificadorP', $identificadorP)->first();
            if (!$production) {
                return response()->json(['message' => 'Producción no encontrada'], 404);
            }
            $guardarCoeficiente = ($producto['piesTabla'] * 0.236) / $production['m3TRM'] / 100;
            $guardarPiesTablaTP = $producto['piesTabla'];

            $sumaPiesTalabTP = $production->piesTablaTP + $guardarPiesTablaTP;
            $sumaCoeficiente = $production->coeficiente + $guardarCoeficiente;

            // Actualizar el estatus
            $production->coeficiente = $sumaCoeficiente;
            $production->piesTablaTP = $sumaPiesTalabTP;
            //$production->fechaFinalizacion = now();
            $production->save();
            $produccionesActualizadas[] = $production;


        }


        return response()->json([
            'message' => 'Estatus actualizado correctamente',
            'production' => $produccionesActualizadas
        ], 200);
    }
}
