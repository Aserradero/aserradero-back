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
    public function storeMultiple(Request $request)
    {
        // Verificar que la solicitud contenga el array 'productos'
    if (!$request->has('materials') || !is_array($request->materials)) {
        return response()->json(["error" => "El formato de los datos es incorrecto. Se espera un array de materias."], 400);
    }

    $productos = $request->materials; // Obtener el array de productos
    $productosGuardados = [];

    foreach ($productos as $producto) {
        // Crear una nueva instancia de Product
        $nuevoProducto = new RawMaterial(); 

        // Asignar valores
        $nuevoProducto->cantidad = $producto['cantidad'];
        $nuevoProducto->diametroUno = $producto['diametroUno'];
        $nuevoProducto->diametroDos = $producto['diametroDos'];
        $nuevoProducto->largo = $producto['largo'];
        $nuevoProducto->metroCR = $producto['metroCR'];
        $nuevoProducto->fechaRegistro = $producto['fechaRegistro'];
        $nuevoProducto->calidad = $producto['calidad'];
        $nuevoProducto->identificadorP = $producto['identificadorP'];

        // Guardar en la base de datos
        $nuevoProducto->save();

        // Agregar el producto guardado a la lista de respuesta
        $productosGuardados[] = $nuevoProducto;
    }

    return response()->json(["message" => "Productos registrados correctamente.", "materials" => $productosGuardados], 201);
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
