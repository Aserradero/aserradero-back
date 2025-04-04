<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RawMaterialInventory;
use Illuminate\Http\Request;


class RawMaterialInventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {       
        // Obtener todos los inventarios de productos y cargar la relación con 'product'
        $rawMaterialInventorys = RawMaterialInventory::with('rawmaterial') // Cargar la relación 'product'
            ->get(); // Obtener todos los registros sin ordenarlos

        // Retornar la respuesta en formato JSON
        return response()->json($rawMaterialInventorys);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeMultiple(Request $request)
    {
        if (!$request->has('materiales') || !is_array($request->materiales)) {
            return response()->json(["error" => "El formato de los datos es incorrecto. Se espera un array de materia."], 400);
        }

        $rawMaterialInventorys = $request->materiales; // Obtener el array de productos
        $productosGuardados = [];

        foreach ($rawMaterialInventorys as $producto) {
            // Crear una nueva instancia de Product
            $nuevoProducto = new RawMaterialInventory();

            // Asignar valores
            $nuevoProducto->idMateria = $producto['idMateria'];
            $nuevoProducto->stockIdeal = $producto['stockIdeal'];
            $nuevoProducto->idUsuario = $producto['idUsuario'];
            // Guardar en la base de datos
            $nuevoProducto->save();

            // Agregar el producto guardado a la lista de respuesta
            $productosGuardados[] = $nuevoProducto;
        }

        return response()->json(["message" => "Materiax registradas correctamente.", "materials" => $productosGuardados], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rawMaterialInventory = RawMaterialInventory::find($id);
        if ($rawMaterialInventory) {
            return response()->json($rawMaterialInventory); // Devuelve los detalles del producto
        }
        return response()->json(['error' => 'Producto no encontrado'], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //actualizar un producto del inventario
        // Buscar el producto por ID
        $rawMaterialInventory = RawMaterialInventory::findOrFail($id);

        //atributos de la materias prima
        $rawMaterialInventory->stockIdeal = $request->stockIdeal;

        $rawMaterialInventory->save();
        // Retornar respuesta JSON
        return response()->json([
            'message' => 'Producto actualizado correctamente',
            'productoInventory' => $rawMaterialInventory
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rawMaterialInventory = RawMaterialInventory::destroy($id);
        return $rawMaterialInventory;
    }
}
