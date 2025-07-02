<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use Illuminate\Http\Request;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'piesTablaTotal' => 'required|numeric',
            'nombreCliente' => 'required|string|max:100',
            'rfc' => 'required|string|max:20',
            'telefono' => 'required|string|max:15',
            'direccion' => 'required|string|max:100',
            'importeLetra' => 'required|string|max:100',
            'tipoVenta' => 'required|string|max:50',
            'subtotal' => 'required|numeric',
            'iva' => 'required|numeric',
            'total' => 'required|numeric',
            'sale_id' => 'required|exists:sales,id',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $factura = Bill::create($request->all());

        return response()->json([
            'message' => 'Factura registrada exitosamente',
            'bill' => $factura
        ], 201);
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
