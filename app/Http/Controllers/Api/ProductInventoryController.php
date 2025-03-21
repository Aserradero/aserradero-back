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
        //mostrar todos los inventarios de productos
        $productInventorys=ProductInventory::all();
        return $productInventorys;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Insertar los inventarios de productos
        //crear el inventario de productos
        $productInventorys = new ProductInventory();


        //insertando los datos del inventario de productos
        $productInventorys->precioUnitario=$request->precioUnitario;
        $productInventorys->stockIdealPT=$request->stockIdealPT;
        $productInventorys->idUsuario=$request->idUsuario;

        $productInventorys->save();
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
