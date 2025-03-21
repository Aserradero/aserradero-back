<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\ContactoMail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;



class EmailController extends Controller
{

    public function enviarCorreo(Request $request)
    {

        $existe = User::where('email', $request->email)->exists();

        if ($existe) {
            $code = rand(1000, 9999);

            $datos = [
                'email' => $request->email,
            ];




            Mail::raw("Tu código es: " . $code, function ($message) use ($datos) {
                $message->to($datos['email'])
                    ->subject('Código de recuperación')
                    ->from('unidadecosanmateo@uniecosanmateo.icu', 'Unidad Económica San Mateo');
            });

            return response()->json([
                'emailVe' => $datos['email'],
                'codigo' => $code
            ]);

        } else {
            return response()->json(['message' => 'El correo no existe'], 404);

        }




    }



    public function updatePassword(Request $request)
    {
      
        // Verificar que el correo exista en la base de datos
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'El correo no está registrado.'], 404);
        }

        // Actualizar la contraseña
        $user->password = Hash::make($request->new_password);  // Hash para encriptar la nueva contraseña
        $user->save();

        return response()->json(['message' => 'Contraseña actualizada correctamente.'], 200);
    }
}
