<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\ProductSale;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ventas = Sale::with([
            'user',                 // Usuario que registró la venta
            'productSales.product', // Productos de la venta
            'bill.user',             // Factura y usuario que la generó
            'bill.client'
        ])->get();

        return response()->json($ventas);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de entrada
        $request->validate([
            'idUsuario' => 'required|exists:users,id',
            'productos' => 'required|array|min:1',
            'productos.*.producto_id' => 'required|exists:products,id',
            'productos.*.cantidad' => 'required|numeric|min:0.001'
        ]);

        DB::beginTransaction();

        try {
            // 1. Crear la venta principal
            $venta = Sale::create([
                'idUsuario' => $request->input('idUsuario')
            ]);

            // 2. Procesar cada producto
            foreach ($request->productos as $producto) {
                // 2.1 Registrar detalle de venta (aunque se descuente de productos equivalentes)
                ProductSale::create([
                    'cantidad' => $producto['cantidad'],
                    'producto_id' => $producto['producto_id'], // producto que eligió el usuario
                    'sale_id' => $venta->id
                ]);

                // 2.2 Obtener características físicas del producto base
                $caracteristicas = DB::table('products')
                    ->join('catalog_products', 'products.idCatalogProduct', '=', 'catalog_products.id')
                    ->select('catalog_products.grosor', 'catalog_products.ancho', 'catalog_products.largo', 'products.calidad')
                    ->where('products.id', $producto['producto_id'])
                    ->first();

                if (!$caracteristicas) {
                    throw new \Exception('No se encontraron características del producto ID: ' . $producto['producto_id']);
                }

                // 2.3 Buscar inventario con productos equivalentes
                $inventarios = DB::table('product_inventories')
                    ->join('products', 'product_inventories.idProducto', '=', 'products.id')
                    ->join('catalog_products', 'products.idCatalogProduct', '=', 'catalog_products.id')
                    ->where('products.calidad', $caracteristicas->calidad)
                    ->where('catalog_products.grosor', $caracteristicas->grosor)
                    ->where('catalog_products.ancho', $caracteristicas->ancho)
                    ->where('catalog_products.largo', $caracteristicas->largo)
                    ->where('product_inventories.stockActual', '>', 0)
                    ->orderBy('product_inventories.created_at') // FIFO
                    ->select('product_inventories.id', 'product_inventories.stockActual')
                    ->lockForUpdate() //  Esto bloquea las filas hasta que la transacción termine
                    ->get();

                // 2.4 Descontar el stock de los registros equivalentes
                $cantidadRestante = $producto['cantidad'];

                foreach ($inventarios as $inv) {
                    if ($cantidadRestante <= 0)
                        break;

                    $porDescontar = min($cantidadRestante, $inv->stockActual);
                    $nuevoStock = $inv->stockActual - $porDescontar;

                    DB::table('product_inventories')
                        ->where('id', $inv->id)
                        ->update(['stockActual' => $nuevoStock]);

                    $cantidadRestante -= $porDescontar;
                }

                // 2.5 Validar si se cubrió toda la cantidad solicitada
                if ($cantidadRestante > 0) {
                    throw new \Exception('Stock insuficiente para el tipo de producto (ID original: ' . $producto['producto_id'] . ')');
                }
            }

            // 3. Confirmar transacción
            DB::commit();

            return response()->json([
                'message' => 'Venta registrada exitosamente',
                'sale_id' => $venta->id
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error' => 'Error al registrar la venta',
                'message' => $e->getMessage()
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
