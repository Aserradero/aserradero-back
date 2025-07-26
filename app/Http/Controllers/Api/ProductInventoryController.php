<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductInventory;
use App\Models\ProductionHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ProductInventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todos los inventarios de productos y cargar la relación con 'product'
        $productInventories = ProductInventory::with('product.catalogProduct') // Cargar la relación 'product'
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
            return response()->json([
                "error" => "El formato de los datos es incorrecto. Se espera un array de productos."
            ], 400);
        }

        $productosAGuardar = $request->productos;
        $productosGuardados = [];

        foreach ($productosAGuardar as $producto) {
            // Obtener el producto actual desde base de datos (para acceder a idCatalogProduct)
            $productoBD = Product::find($producto['idProducto']);

            if (!$productoBD) {
                return response()->json([
                    "error" => "Producto con ID {$producto['idProducto']} no encontrado."
                ], 404);
            }

            // Obtener el catálogo asociado
            $idCatalogProduct = $productoBD->idCatalogProduct;

            // Buscar si ya hay otro inventario de producto con el mismo catálogo
            $inventarioRelacionado = ProductInventory::whereHas('product', function ($query) use ($idCatalogProduct) {
                $query->where('idCatalogProduct', $idCatalogProduct);
            })->first();

            // Crear nuevo inventario
            $nuevoInventario = new ProductInventory();
            $nuevoInventario->idProducto = $producto['idProducto'];
            $nuevoInventario->precioUnitario = $producto['precioUnitario'];

            $nuevoInventario->stockIdealPT = $inventarioRelacionado
                ? $inventarioRelacionado->stockIdealPT
                : $producto['stockIdealPT'];

            $nuevoInventario->stockActual = $producto['stockActual'];
            $nuevoInventario->idUsuario = $producto['idUsuario'];
            $nuevoInventario->save();

            $productosGuardados[] = $nuevoInventario;
        }

        return response()->json([
            "message" => "Productos registrados correctamente.",
            "productos" => $productosGuardados
        ], 201);
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

        // Buscar productos del inventario según sus características
        $productos = ProductInventory::whereHas('product', function ($query) use ($request) {
            $query->where('calidad', $request->calidad)
                ->where('grosor', $request->grosor)
                ->where('ancho', $request->ancho)
                ->where('largo', $request->largo);
        })->get();

        // Contador para catálogo actualizado
        $catalogosActualizados = 0;

        foreach ($productos as $producto) {
            // Actualizar el inventario
            $producto->precioUnitario = $request->precioUnitario;
            $producto->stockIdealPT = $request->stockIdealPT;
            $producto->save();

            // También actualiza el precio en el catálogo asociado al producto
            if ($producto->product && $producto->product->catalogProduct) {
                $catalog = $producto->product->catalogProduct;
                $catalog->precioUnitario = $request->precioUnitario;
                $catalog->save();
                $catalogosActualizados++;
            }
        }

        return response()->json([
            'message' => 'Productos e ítems del catálogo actualizados correctamente',
            'productos_actualizados' => count($productos),
            'catalogos_actualizados' => $catalogosActualizados
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

        // Validar si el producto ya está relacionado a una venta
        $productoEnVenta = DB::table('product_sales')->where('producto_id', $idProducto)->exists();
        if ($productoEnVenta) {
            return response()->json([
                'message' => 'El producto ya fue utilizado en una venta. No se puede modificar ni eliminar.',
            ], 403);
        }

        // Validación de existencia de cantidad suficiente
        if ($producto->cantidad < $cantidadARestar) {
            return response()->json([
                'message' => 'No hay suficiente cantidad disponible para restar',
                'cantidadDisponible' => $producto->cantidad
            ], 400);
        }
        //  Actualizar el producto
        $producto->cantidad -= $cantidadARestar;
        $producto->piesTabla = ($producto['ancho'] * $producto['largo'] * $producto['grosor'] * $producto['cantidad']) / 12;
        $producto->save();

        //  Actualizar el stock del inventario, evitando valores negativos
        if ($productInventory->stockActual > 0) {
            $productInventory->stockActual = max(0, $productInventory->stockActual - $cantidadARestar);
            $productInventory->save();
        }

        // Obtener todos los productos relacionados con la misma producción
        $productosRelacionados = Product::where('identificadorP', $identificadorP)->get();

        //  Calcular nuevo piesTablaTP
        $totalPiesTablaTP = 0;
        foreach ($productosRelacionados as $prod) {
            $totalPiesTablaTP += ($prod->ancho * $prod->largo * $prod->grosor * $prod->cantidad) / 12;
        }

        // 🔧 Actualizar producción
        $production->piesTablaTP = $totalPiesTablaTP;
        $production->coeficiente = ($production->piesTablaTP * 0.236) / $production->m3TRM / 100;
        $production->save();

        // Si la cantidad del producto llegó a 0, puedes notificar pero **no eliminar**
        if ($producto->cantidad == 0) {
            return response()->json([
                'message' => 'La cantidad del producto llegó a 0, pero no se eliminó porque no está permitido.',
                'cantidadDisponible' => 0,
                'eliminado' => false,
                'production_updated' => $production
            ], 200);
        }

        return response()->json([
            'message' => 'Cantidad actualizada correctamente',
            'cantidadRestante' => $producto->cantidad,
            'production_updated' => $production
        ], 200);
    }

}
