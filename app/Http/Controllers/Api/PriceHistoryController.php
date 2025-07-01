<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PrecieHistory;
use Illuminate\Http\Request;

class PriceHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() 
    {
        $priceHistory = PrecieHistory::all();
        return $priceHistory;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $history = new PrecieHistory();
        $history->calidad = $request->calidad;
        $history->precio = $request->precio;
        $history->ancho = $request->ancho;
        $history->grosor = $request->grosor;
        $history->largo = $request->largo;
        $history->fechaRegistro = $request->fechaRegistro;
        $history->fechaActualizada = $request->fechaActualizada;
        $history->idUsuario = $request->idUsuario; 
                
        $history->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $history = PrecieHistory::find($id);
        return $history;
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
