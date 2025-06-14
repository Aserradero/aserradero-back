<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductInventory;
use App\Models\ProductionHistory;
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
        $productInventory = ProductInventory::findOrFail($id);

        //atributos de la materias prima
        $productInventory->precioUnitario = $request->precioUnitario;
        $productInventory->stockIdealPT = $request->stockIdealPT;

        $productInventory->save();
        // Retornar respuesta JSON
        return response()->json([
            'message' => 'Producto actualizado correctamente',
            'productoInventory' => $productInventory
        ], 200);
    }

    public function updatePrecioStock(Request $request)
{
    // Validar los campos requeridos
    $request->validate([
        'precioUnitario' => 'required|numeric',
        'stockIdealPT' => 'required|numeric',
    ]);

    // Buscar productos que coincidan con las características
    $productos = ProductInventory::whereHas('product', function ($query) use ($request) {
        $query->where('calidad', $request->calidad)
              ->where('grosor', $request->grosor)
              ->where('ancho', $request->ancho)
              ->where('largo', $request->largo);
    })->get();

    // Actualizar cada producto
    foreach ($productos as $producto) {
        $producto->precioUnitario = $request->precioUnitario;
        $producto->stockIdealPT = $request->stockIdealPT;
        $producto->save();
    }

    return response()->json([
        'message' => 'Productos actualizados correctamente',
        'cantidad' => count($productos)
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

    public function eliminarProductoCantidad(Request $request, string $id)
    {
        $request->validate([
            'cantidad' => 'required|integer|min:1'
        ]);

        $cantidadARestar = $request->cantidad;
        $productInventory = ProductInventory::findOrFail($id);
        $idProducto = $productInventory->idProducto;
        $producto = Product::findOrFail($idProducto);
        $identificadorP = $producto['identificadorP'];
        $production = ProductionHistory::where('identificadorP', $identificadorP)->firstOrFail();

        if ($producto->cantidad < $cantidadARestar) {
            return response()->json([
                'message' => 'No hay suficiente cantidad disponible para restar',
                'cantidadDisponible' => $producto->cantidad
            ], 400);
        }

        // Actualizar el producto
        $producto->cantidad -= $cantidadARestar;
        $producto->piesTabla = ($producto['ancho'] * $producto['largo'] * $producto['grosor'] * $producto['cantidad']) / 12;
        $producto->save();

        // Obtener TODOS los productos con el mismo identificadorP
        $productosRelacionados = Product::where('identificadorP', $identificadorP)->get();

        // Calcular el nuevo piesTablaTP para la producción
        $totalPiesTablaTP = 0;
        foreach ($productosRelacionados as $prod) {
            $totalPiesTablaTP += ($prod->ancho * $prod->largo * $prod->grosor * $prod->cantidad) / 12;
        }

        // Actualizar la producción
        $production->piesTablaTP = $totalPiesTablaTP;
        $production->coeficiente = ($production->piesTablaTP * 0.236) / $production->m3TRM / 100; // Actualizar el coeficiente
        $production->save();

        // Eliminar si la cantidad llega a 0
        if ($producto->cantidad == 0) {
            $productInventory->delete();
            $producto->delete();

            return response()->json([
                'message' => 'Producto eliminado correctamente porque la cantidad llegó a 0',
                'cantidadDisponible' => 0,
                'eliminado' => true,
                'production_updated' => $production // Devuelve los datos actualizados de producción
            ], 200);
        }

        return response()->json([
            'message' => 'Cantidad actualizada correctamente',
            'cantidadRestante' => $producto->cantidad,
            'production_updated' => $production // Devuelve los datos actualizados de producción
        ], 200);
    }
}
