<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RawMaterial;
use Illuminate\Http\Request;
use Psy\Readline\Hoa\Console;
use Termwind\Components\Raw;


use function Laravel\Prompts\error;

class RawMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //mostrar toda la materia prima 
        $rawMaterial = RawMaterial::all();
        return RawMaterial::orderBy('created_at', 'asc')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //crear un objeto de la clase materia prima
        $rawMaterial = new RawMaterial();

        //atributos de la materia prima
        $rawMaterial->cantidad = $request->cantidad;
        $rawMaterial->diametroUno = $request->diametroUno;
        $rawMaterial->diametroDos = $request->diametroDos;
        $rawMaterial->largo = $request->largo;
        $rawMaterial->metroCR = $request->metroCR;
        $rawMaterial->fechaRegistro = $request->fechaRegistro;
        $rawMaterial->calidad = $request->calidad;
        $rawMaterial->identificadorP = $request->identificadorP;
        $rawMaterial->rawMaterialInventory_id = $request->rawMaterialInventory_id;


        $rawMaterial->save();
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
        //actualizar una materia prima
        // Buscar el producto por ID
        $rawMaterial = RawMaterial::findOrFail($id);

        //atributos de la materias prima
        $rawMaterial->cantidad = $request->cantidad;
        $rawMaterial->diametroUno = $request->diametroUno;
        $rawMaterial->diametroDos = $request->diametroDos;
        $rawMaterial->largo = $request->largo;
        $rawMaterial->metroCR = $request->metroCR;
        $rawMaterial->fechaRegistro = $request->fechaRegistro;
        $rawMaterial->calidad = $request->calidad;
        $rawMaterial->identificadorP = $request->identificadorP;
        $rawMaterial->rawMaterialInventory_id = $request->rawMaterialInventory_id;

        $rawMaterial->update($request->all());
        // Retornar respuesta JSON
        return response()->json([
            'message' => 'Materia prima  actualizada correctamente',
            'rawMaterial' => $rawMaterial
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function updateIdentificadorP(Request $request)
    {
        $totalActualizados = 0;
        $idsNoEncontrados = [];

        foreach ($request->all() as $materiaP) {
            // Verificar si el ID existe antes de actualizar
            $exists = RawMaterial::where('id', $materiaP['id'])->exists();

            if ($exists) {
                RawMaterial::where('id', $materiaP['id'])
                    ->update(['identificadorP' => $materiaP['identificadorP'],
                    'updated_at' => $materiaP['updated_at'] ?? now() // Actualiza la fecha a la fecha actual
                    ]);
                $totalActualizados++;
            } else {
                $idsNoEncontrados[] = $materiaP['id'];
            }
        }

        return response()->json([
            'message' => 'Proceso de actualización completado',
            'total_actualizados' => $totalActualizados,
            'ids_no_encontrados' => $idsNoEncontrados
        ], 200);
    }
}
