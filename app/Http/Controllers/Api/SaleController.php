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
        //Insertando una venta

        $request->validate([
            'idUsuario' => 'required|exists:users,id',
            'productos' => 'required|array|min:1',
            'productos.*.producto_id' => 'required|exists:products,id',
            'productos.*.cantidad' => 'required|numeric|min:0.001'
        ]);

        DB::beginTransaction();

        try {
            $venta = Sale::create([
                'idUsuario' => $request->input('idUsuario')
            ]);

            foreach ($request->productos as $producto) {
                ProductSale::create([
                    'cantidad' => $producto['cantidad'],
                    'producto_id' => $producto['producto_id'],
                    'sale_id' => $venta->id
                ]);
            }

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
