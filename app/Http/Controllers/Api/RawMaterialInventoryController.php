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
        //ver todo el inventario de lamateria prima disponible
        $rawMaterialInventory = RawMaterialInventory::all();
        return $rawMaterialInventory;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //insertar datos del inventario de la matetia prima. 
        $rawMaterialInventory = new RawMaterialInventory();


        //atributos del inventario de materia prima
        $rawMaterialInventory->stockIdeal = $request->stockIdeal;
        $rawMaterialInventory->idUsuario = $request->idUsuario;

        $rawMaterialInventory->save();
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
