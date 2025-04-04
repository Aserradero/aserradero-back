<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PersonalAccessToken;
use Illuminate\Support\Facades\Hash;
use Psy\Readline\Hoa\Console;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\EmailController;
use Carbon\Carbon;



class UseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return $users;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->apellidos = $request->apellidos;
        $user->telefono = $request->telefono;
        $user->genero = $request->genero;
        $user->nombreUsuario = $request->nombreUsuario;
        $user->contrasena = $request->contrasena;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->assignRole($request->rol);  // Asigna el rol recibido desde el formulario
        $user->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find(id: $id);
        return $user;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail(id: $request->id);
        $user->name = $request->name;
        $user->apellidos = $request->apellidos;
        $user->telefono = $request->telefono;
        $user->genero = $request->genero;
        $user->rol = $request->rol;
        $user->nombreUsuario = $request->nombreUsuario;
        $user->contrasena = $request->contrasena;
        $user->email = $request->email;
        $user->password = $request->password;

        $user->save();
        return $user;
    }

    public function updatePassword(Request $request)
    {
        $idsNoEncontrados = [];

        foreach ($request->all() as $usuario) {
            // Verificar si el ID existe antes de actualizar
            $exists = User::where('id', $usuario['id'])->exists();

            if ($exists) {
                User::where('id', $usuario['id'])
                    ->update(['contrasena' => $usuario['contrasena']]);
            } else {
                $idsNoEncontrados[] = $usuario['id'];
            }
        }

        return response()->json([
            'message' => 'Tu contraseña se ha actualizado',
            'ids_no_encontrados' => $idsNoEncontrados
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::destroy(ids: $id);
        return $user;
    }


    /*

    public function login(Request $request)
    {

        // Validar los datos de entrada
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ]);

        //Intentar autenticar al usuario
        //obteniendo al ususario, verificando en la base de dats
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json([
                'message' => 'Credenciales incorrectas'
            ]);
        }

        try {
            // Obtener el usuario autenticado
            $user = Auth::user();

            // Verificar si el usuario existe antes de crear el token
            if (!$user) {
                return response()->json(['message' => 'Usuario no encontrado'], 404);
            }

            // Generar el token con Laravel Sanctum
            if (method_exists($user, 'createToken')) {
                $token = $user->createToken('AuthToken')->plainTextToken;
            } else {
                return response()->json([
                    'message' => 'Error: createToken() no está disponible en el modelo User'
                ], 500);
            }

            // Retornar la respuesta con el token
            return response()->json([
                'message' => 'Login exitoso',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->getRoleNames()->first()
                ],
                'token' => $token
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al generar el token',
                'error' => $e->getMessage()
            ], 500);
        }
    }
        */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ]);

        // Verifica credenciales
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json([
                'message' => 'Credenciales incorrectas'
            ], 401);
        }

        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json(['message' => 'Usuario no encontrado'], 404);
            }


            // ESTE IF BLOQUEA EL LOGIN SI YA TIENE UNA SESIÓN ACTIVA
            if ($user->tokens()->where('name', 'AuthToken')->exists()) {
                return response()->json([
                    'message' => 'Ya tienes una sesión activa.'
                ], 403);
            }

            //  Solo si no tiene token, se crea uno nuevo
            //$token = $user->createToken('AuthToken')->plainTextToken;
            $token = $user->createToken('AuthToken', ['*'], Carbon::now()->addMinutes(env('SANCTUM_TOKEN_EXPIRATION')))->plainTextToken;

            return response()->json([
                'message' => 'Login exitoso',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->getRoleNames()->first()
                ],
                'token' => $token
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al generar el token',
                'error' => $e->getMessage()
            ], 500);
        }
    }




    /*
    public function logout(Request $request)
    {
        try {
            // Obtener el usuario autenticado
            $user = Auth::user();

            // Verificar si el usuario está autenticado
            if (!$user) {
                return response()->json(['message' => 'No autenticado'], 401);
            }

            // Eliminar el token actual para cerrar sesión
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'message' => 'Sesión cerrada exitosamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al cerrar sesión',
                'error' => $e->getMessage()
            ], 500);
        }
    }
        */
    public function logout(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Usuario no autenticado'], 401);
        }

        // Elimina todos los tokens del usuario
        $user->tokens->each(function ($token) {
            $token->delete();
        });

        return response()->json(['message' => 'Sesión cerrada correctamente.']);
    }


    public function updateRegister(Request $request, string $email)
    {
        // Encuentra al usuario usando el correo electrónico de la URL
        $user = User::where('email', $email)->firstOrFail();  // Usamos 'where' ya que el email es único

        // Actualiza los campos del usuario
        $user->name = $request->name;
        $user->apellidos = $request->apellidos;
        $user->telefono = $request->telefono;
        $user->genero = $request->genero;
        $user->nombreUsuario = $request->nombreUsuario;
        $user->contrasena = $request->contrasena;
        $user->password = Hash::make($request->password);
        $user->assignRole($request->rol);  // Asigna el rol recibido desde el formulario

        // Guarda los cambios
        $user->save();

        return response()->json($user);  // Devuelve el usuario actualizado como respuesta
    }

    /*
    public function someApiMethod(Request $request)
    {
        $token = $request->bearerToken();

        // Verificar si el token ha expirado
        $user = Auth::user();
        if ($user && $user->tokens->isEmpty()) {
            return response()->json(['message' => 'Sesión expirada'], 401);
        }

        return response()->json(['message' => 'La sesión sigue activa'], 202);
    }
    */
    public function someApiMethod(Request $request)
    {
        // Obtener el token
        $token = $request->bearerToken();

        // Verificar si el usuario está autenticado
        $user = Auth::user();
        if ($user && $user->tokens->isEmpty()) {
            return response()->json(['message' => 'Sesión expirada'], 401);
        }

        // Obtener el token de la base de datos (o cualquier otra propiedad donde lo guardaste)
        $tokenExpiration = $user->tokens->first()->created_at;  // Asumiendo que estás almacenando la fecha de creación del token en la base de datos

        // Calcular el tiempo transcurrido desde que se emitió el token
        $timeElapsed = Carbon::now()->diffInMinutes($tokenExpiration);  // Puedes usar `diffInSeconds` si prefieres el tiempo en segundos

        // Verificar si el token ha expirado (si lo deseas, puedes manejarlo aquí)
        $tokenExpirationTime = $user->tokens->first()->expires_at;  // Obtener la fecha de expiración
        if ($tokenExpirationTime && Carbon::now()->gt($tokenExpirationTime)) {
            return response()->json(['message' => 'Sesión expirada', 'time_elapsed' => $timeElapsed . ' minutos'], 401);
        }

        // Responder con la sesión activa y el tiempo transcurrido
        return response()->json(['message' => 'La sesión sigue activa', 'time_elapsed' => $timeElapsed . ' minutos'], 202);
    }





}
