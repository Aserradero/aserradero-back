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
            'precioUnitario' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $atributos = $request->only(['grosor', 'ancho', 'largo', 'tipoProducto', 'precioUnitario']);

        // Paso 1: Determinar el código a usar
        $productoMismoTipo = CatalogProduct::where('tipoProducto', $atributos['tipoProducto'])->first();
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/productos', $imageName);
            $atributos['image'] = 'productos/' . $imageName; // Guarda la ruta para la base de datos
        } else {
            // Si no hay imagen, puedes asignar null o dejarlo así
            $atributos['image'] = "productos/1748986073_th.jpg";
        }

        if ($productoMismoTipo) {
            $atributos['codigoProducto'] = $productoMismoTipo->codigoProducto;
        } else {
            $request->validate(['codigoProducto' => 'required']); // <-- Solo requerido, no unique aquí
            $atributos['codigoProducto'] = $request->codigoProducto;
        }

        // Paso 2: Validar que el código no esté en uso en OTRO tipo (si el tipo actual es nuevo)
        $codigoEnOtroTipo = CatalogProduct::where('codigoProducto', $atributos['codigoProducto'])
            ->where('tipoProducto', '!=', $atributos['tipoProducto'])
            ->exists();

        if ($codigoEnOtroTipo) {
            return response()->json([
                'message' => 'El código ya está en uso para otro tipo de producto',
                'conflictos' => ['codigoProducto' => $atributos['codigoProducto']]
            ], 409);
        }

        // Paso 3: Verificar duplicados exactos (mismo tipo + medidas)
        $duplicadoExacto = CatalogProduct::where([
            'codigoProducto' => $atributos['codigoProducto'],
            'tipoProducto' => $atributos['tipoProducto'],
            'grosor' => $atributos['grosor'],
            'ancho' => $atributos['ancho'],
            'largo' => $atributos['largo']
        ])->exists();

        if ($duplicadoExacto) {
            return response()->json(['message' => 'Producto duplicado'], 409);
        }

        // Crear el producto
        $producto = CatalogProduct::create($atributos);
        return response()->json($producto, 201);
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
