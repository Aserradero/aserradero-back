<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\ContactoMail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;


class EmailController extends Controller
{

    public function enviarCorreo(Request $request)
    {

        $existe = User::where('email', $request->email)->exists();

        if ($existe) {
            $numero = rand(100000, 999999);

            $datos = [
                'email' => $request->email,
            ];




            Mail::raw("Tu código es: " . $numero, function ($message) use ($datos) {
                $message->to($datos['email'])
                    ->subject('Código de recuperación')
                    ->from('unidadecosanmateo@uniecosanmateo.icu', 'Unidad Económica San Mateo');
            });
        } else {
            return response()->json(['message' => 'El correo no existe'], 404);

        }


    }
}
