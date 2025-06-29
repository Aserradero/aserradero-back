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
        //Crear una venta

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación
        $request->validate([
            'idUsuario' => 'required|exists:users,id',
            'productos' => 'required|array|min:1',
            'productos.*.producto_id' => 'required|exists:products,id',
            'productos.*.cantidad' => 'required|numeric|min:0.001'
        ]);

        DB::beginTransaction();

        try {
            // 1. Crear la venta
            $venta = Sale::create([
                'idUsuario' => $request->input('idUsuario')
            ]);

            // 2. Procesar productos vendidos
            foreach ($request->productos as $producto) {
                // 2.1 Registrar detalle de venta
                ProductSale::create([
                    'cantidad' => $producto['cantidad'],
                    'producto_id' => $producto['producto_id'],
                    'sale_id' => $venta->id
                ]);

                // 2.2 Descontar stock FIFO desde product_inventories
                $cantidadRestante = $producto['cantidad'];

                $inventarios = DB::table('product_inventories')
                    ->where('idProducto', $producto['producto_id'])
                    ->where('stockActual', '>', 0)
                    ->orderBy('created_at') // FIFO
                    ->get();

                foreach ($inventarios as $inv) {
                    if ($cantidadRestante <= 0)
                        break;

                    $porDescontar = min($cantidadRestante, $inv->stockActual);
                    $nuevoStock = $inv->stockActual - $porDescontar;

                    // Solo actualizar el stock
                    DB::table('product_inventories')
                        ->where('id', $inv->id)
                        ->update(['stockActual' => $nuevoStock]);

                    $cantidadRestante -= $porDescontar;
                }

                // 2.3 Validar si alcanzó el stock
                if ($cantidadRestante > 0) {
                    throw new \Exception('Stock insuficiente para el producto ID: ' . $producto['producto_id']);
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
