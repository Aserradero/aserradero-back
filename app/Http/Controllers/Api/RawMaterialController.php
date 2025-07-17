<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RawMaterial;
use Illuminate\Http\Request;
use Psy\Readline\Hoa\Console;
use Termwind\Components\Raw;
use Illuminate\Support\Facades\DB;



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
    public function storeMultiple(Request $request)
    {
        if (!$request->has('materials') || !is_array($request->materials)) {
            return response()->json(["error" => "El formato de los datos es incorrecto. Se espera un array de materias."], 400);
        }

        $productos = $request->materials;
        $productosGuardados = [];

        foreach ($productos as $index => $producto) {
            $identificador = $producto['identificadorP'] ?? null;

            // Validar que identificadorP no se repita en la base de datos si es diferente de 0
            if ($identificador !== null && $identificador != 0) {
                $existe = DB::table('raw_materials')
                    ->where('identificadorP', $identificador)
                    ->exists();

                if ($existe) {
                    return response()->json([
                        "error" => "El identificadorP '{$identificador}' ya existe y no puede repetirse.",
                        "index" => $index,
                    ], 422);
                }
            }

            // Crear y guardar la materia prima
            $nuevoProducto = new RawMaterial();
            $nuevoProducto->cantidad = $producto['cantidad'];
            $nuevoProducto->diametroUno = $producto['diametroUno'];
            $nuevoProducto->diametroDos = $producto['diametroDos'];
            $nuevoProducto->largo = $producto['largo'];
            $nuevoProducto->metroCR = $producto['metroCR'];
            $nuevoProducto->fechaRegistro = $producto['fechaRegistro'];
            $nuevoProducto->calidad = $producto['calidad'];
            $nuevoProducto->identificadorP = $identificador;
            $nuevoProducto->save();

            $productosGuardados[] = $nuevoProducto;
        }

        return response()->json([
            "message" => "Materias primas registradas correctamente.",
            "materials" => $productosGuardados,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //Buscar un producto por su id
        $material = RawMaterial::find($id);
        return $material;
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
        //eliminar una materia
        $rawMaterial = RawMaterial::destroy($id);
        return $rawMaterial;
    }

    public function updateIdentificadorP(Request $request)
    {
        $totalActualizados = 0;
        $idsNoEncontrados = [];
        $idsYaAsignados = [];
        $idsConcurrencia = [];

        DB::beginTransaction();

        try {
            foreach ($request->all() as $materiaP) {
                // Usar bloqueo SELECT FOR UPDATE para evitar condiciones de carrera
                $rawMaterial = RawMaterial::where('id', $materiaP['id'])->lockForUpdate()->first();

                if (!$rawMaterial) {
                    $idsNoEncontrados[] = $materiaP['id'];
                    continue;
                }

                if (!is_null($rawMaterial->identificadorP)) {
                    // Ya tiene identificadorP asignado, no se puede volver a asignar
                    $idsYaAsignados[] = $materiaP['id'];
                    continue;
                }

                // Asignar identificador
                $rawMaterial->identificadorP = $materiaP['identificadorP'];
                $rawMaterial->updated_at = $materiaP['updated_at'] ?? now();
                $rawMaterial->save();

                $totalActualizados++;
            }

            DB::commit();

            return response()->json([
                'message' => 'Proceso de actualización completado',
                'total_actualizados' => $totalActualizados,
                'ids_no_encontrados' => $idsNoEncontrados,
                'ids_ya_asignados' => $idsYaAsignados
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error durante la actualización',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function getGroupedRawMaterials()
    {
        $grouped = DB::table('raw_materials')
            ->select(
                'calidad',
                'diametroUno',
                'diametroDos',
                'largo',
                DB::raw('SUM(metroCR) as total_metroCR'),
                DB::raw('COUNT(*) as total_rollos')
            )
            ->whereNull('identificadorP') 
            ->groupBy('calidad', 'diametroUno', 'diametroDos', 'largo')
            ->orderBy('calidad')
            ->get();

        return response()->json($grouped);
    }




}
