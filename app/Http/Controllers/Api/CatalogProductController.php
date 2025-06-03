<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CatalogProduct;
use Illuminate\Http\Request;



class CatalogProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Obtener los productos del catalogo
        $catalogProduct = CatalogProduct::all();
        return $catalogProduct;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'grosor' => 'required|numeric',
            'ancho' => 'required|numeric',
            'largo' => 'required|numeric',
            'tipoProducto' => 'required',
            'precioUnitario' => 'required|numeric'
        ]);

        $atributos = $request->only([
            'grosor',
            'ancho',
            'largo',
            'tipoProducto',
            'precioUnitario'
        ]);

        // Buscar si ya existe este tipo de producto para obtener su código
        $productoMismoTipo = CatalogProduct::where('tipoProducto', $atributos['tipoProducto'])->first();

        if ($productoMismoTipo) {
            $atributos['codigoProducto'] = $productoMismoTipo->codigoProducto;
        } else {
            $request->validate(['codigoProducto' => 'required']);
            $atributos['codigoProducto'] = $request->codigoProducto;
        }

        // Verificar si ya existe un producto idéntico
        $productoExistente = CatalogProduct::where('codigoProducto', $atributos['codigoProducto'])
            ->where('tipoProducto', $atributos['tipoProducto'])
            ->where('grosor', $atributos['grosor'])
            ->where('ancho', $atributos['ancho'])
            ->where('largo', $atributos['largo'])
            ->first();

        if ($productoExistente) {
            $camposConflictivos = [
                'codigoProducto' => $productoExistente->codigoProducto,
                'tipoProducto' => $productoExistente->tipoProducto,
                'medidas' => [
                    'grosor' => $productoExistente->grosor,
                    'ancho' => $productoExistente->ancho,
                    'largo' => $productoExistente->largo
                ]
            ];

            return response()->json([
                'message' => 'Ya existe un producto idéntico',
                'conflictos' => $camposConflictivos,
                'productoExistente' => $productoExistente
            ], 409);
        }

        $nuevoProducto = CatalogProduct::create($atributos);

        return response()->json([
            'message' => 'Producto registrado exitosamente',
            'producto' => $nuevoProducto
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
