<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //retornar todos los productos
        $products = Product::all();
        return $products;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeMultiple(Request $request)
    {
        // Verificar que la solicitud contenga el array 'productos'
    if (!$request->has('productos') || !is_array($request->productos)) {
        return response()->json(["error" => "El formato de los datos es incorrecto. Se espera un array de productos."], 400);
    }

    $productos = $request->productos; // Obtener el array de productos

    $productosGuardados = [];

    foreach ($productos as $producto) {
        // Crear una nueva instancia de Product
        $nuevoProducto = new Product(); 

        // Asignar valores
        $nuevoProducto->precio = $producto['precio'];
        $nuevoProducto->calidad = $producto['calidad'];
        $nuevoProducto->cantidad = $producto['cantidad'];
        $nuevoProducto->ancho = $producto['ancho'];
        $nuevoProducto->grosor = $producto['grosor'];
        $nuevoProducto->largo = $producto['largo'];
        $nuevoProducto->piesTabla = $producto['piesTabla'];
        $nuevoProducto->fechaRegistro = $producto['fechaRegistro'];
        $nuevoProducto->identificadorP = $producto['identificadorP'];

        // Guardar en la base de datos
        $nuevoProducto->save();

        // Agregar el producto guardado a la lista de respuesta
        $productosGuardados[] = $nuevoProducto;
    }

    return response()->json(["message" => "Productos registrados correctamente.", "productos" => $productosGuardados], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //Buscar un producto por su id
        $product = Product::find($id);
        return $product;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Buscar el producto por ID
        $product = Product::findOrFail($id);

        // Validación de los datos
        $request->validate([
            'precio' => 'required|numeric',
            'calidad' => 'required|string',
            'cantidad' => 'required|integer',
            'ancho' => 'required|numeric',
            'grosor' => 'required|numeric',
            'largo' => 'required|numeric',
            'piesTabla' => 'required|numeric',
            'fechaRegistro' => 'required|date',
            'identificadorP' => 'required|integer'
        ]);

        // Actualizar el producto con los datos del request
        $product->update($request->all());

        // Retornar respuesta JSON
        return response()->json([
            'message' => 'Producto actualizado correctamente',
            'product' => $product
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //eliminar un producto
        $product = Product::destroy($id);
        return $product;
    }
}
