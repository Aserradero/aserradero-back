<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Obtener todos los clientes
        $clients = Client::all();
        return $clients;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Insertar un nuevo cliente
        $request->validate([
            'nombreCliente' => 'required|string|max:255',
            'apellidosCliente' => 'required|string|max:255',
            'rfc' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'correoElectronico' => 'nullable|email|max:255',
        ]);
        $cliente = Client::create($request->all());
        return response()->json([
            'message' => 'Cliente registrado exitosamente',
            'client' => $cliente,
            'client_id' => $cliente->id
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    //buscar cliente por RFC
    public function findByRfc(Request $request)
    {
        $rfc = $request->query('rfc');
        $client = Client::where('rfc', $rfc)->first();

        if (!$client) {
            return response()->json(['message' => 'Cliente no encontrado'], 404);
        }

        return response()->json($client);
    }


    public function buscarPorRfc(Request $request)
    {
        $request->validate([
            'rfc' => 'required|string'
        ]);

        $cliente = Client::where('rfc', $request->rfc)->first();

        if ($cliente) {
            return response()->json(['cliente' => $cliente], 200);
        } else {
            return response()->json(['cliente' => null], 404);
        }
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validar los campos básicos
        $validated = $request->validate([
            'nombreCliente' => 'required|string|max:255',
            'apellidosCliente' => 'required|string|max:255',
            'rfc' => 'required|string|max:18',
            'telefono' => 'required|string|max:10',
            'direccion' => 'required|string|max:255',
            'correoElectronico' => 'required|email|max:255',
        ]);

        // Buscar el cliente actual
        $cliente = Client::findOrFail($id);

        // Verificar si hay duplicados en otros registros
        $mensajesError = [];

        if (
            Client::where('rfc', $validated['rfc'])
                ->where('id', '!=', $cliente->id)
                ->exists()
        ) {
            $mensajesError[] = "Ya existe otro cliente con este RFC. Por favor, ingresa uno diferente.";
        }

        if (
            Client::where('telefono', $validated['telefono'])
                ->where('id', '!=', $cliente->id)
                ->exists()
        ) {
            $mensajesError[] = "Ya existe otro cliente con este número telefónico. Por favor, verifica o usa otro.";
        }

        if (
            Client::where('correoElectronico', $validated['correoElectronico'])
                ->where('id', '!=', $cliente->id)
                ->exists()
        ) {
            $mensajesError[] = "Ya existe otro cliente con este correo electrónico. Por favor, usa uno diferente.";
        }

        // Si hay errores, retornar respuesta con código 409
        if (!empty($mensajesError)) {
            return response()->json([
                'message' => 'Conflicto de datos encontrados',
                'errors' => $mensajesError,
            ], 409);
        }

        // Actualizar cliente si no hay conflictos
        $cliente->update($validated);

        return response()->json([
            'message' => 'Cliente actualizado correctamente',
            'cliente' => $cliente
        ], 200);
    }



    /**
     * Remove the specified resource from storage.
     */

    public function destroy(string $id)
    {
        try {
            $client = Client::findOrFail($id);
            $client->delete();

            return response()->json([
                'message' => 'Cliente eliminado correctamente.'
            ], 200);

        } catch (QueryException $e) {
            // Código de error SQL para violación de restricción de clave foránea: 23000
            if ($e->getCode() === '23000') {
                return response()->json([
                    'error' => 'No se puede eliminar el cliente porque está relacionado con una factura.'
                ], 409);
            }

            // Otros errores de base de datos
            Log::error('Error al eliminar cliente: ' . $e->getMessage());

            return response()->json([
                'error' => 'Ocurrió un error inesperado al intentar eliminar el cliente.'
            ], 500);
        }
    }
}
