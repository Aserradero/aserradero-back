<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductInventory;
use Illuminate\Http\Request;

class ProductInventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todos los inventarios de productos y cargar la relación con 'product'
        $productInventories = ProductInventory::with('product') // Cargar la relación 'product'
            ->get(); // Obtener todos los registros sin ordenarlos

        // Retornar la respuesta en formato JSON
        return response()->json($productInventories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeMultiple(Request $request)
    {
        if (!$request->has('productos') || !is_array($request->productos)) {
            return response()->json(["error" => "El formato de los datos es incorrecto. Se espera un array de productos."], 400);
        }

        $productInventorys = $request->productos; // Obtener el array de productos
        $productosGuardados = [];

        foreach ($productInventorys as $producto) {
            // Crear una nueva instancia de Product
            $nuevoProducto = new ProductInventory();

            // Asignar valores
            $nuevoProducto->idProducto = $producto['idProducto'];
            $nuevoProducto->precioUnitario = $producto['precioUnitario'];
            $nuevoProducto->stockIdealPT = $producto['stockIdealPT'];
            $nuevoProducto->idUsuario = $producto['idUsuario'];
            // Guardar en la base de datos
            $nuevoProducto->save();

            // Agregar el producto guardado a la lista de respuesta
            $productosGuardados[] = $nuevoProducto;
        }

        return response()->json(["message" => "Productos registrados correctamente.", "productos" => $productosGuardados], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $productInventory = ProductInventory::find($id);

        if ($productInventory) {
            return response()->json($productInventory); // Devuelve los detalles del producto
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
        $productInventorys = ProductInventory::findOrFail($id);

        //atributos de la materias prima
        $productInventorys->idProducto = $request->idProducto;
        $productInventorys->precioUnitario = $request->precioUnitario;
        $productInventorys->stockIdealPT = $request->stockIdealPT;
        $productInventorys->idUsuario = $request->idUsuario;

        $productInventorys->update($request->all());
        // Retornar respuesta JSON
        return response()->json([
            'message' => 'Producto actualizado correctamente',
            'productoInventory' => $productInventorys
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $productInventorys = ProductInventory::destroy($id);
        return $productInventorys;
    }
}
