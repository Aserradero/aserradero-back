<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\CotizacionPdfMail;
use App\Mail\VentaPdfMail;
use Illuminate\Http\Request;
use App\Mail\ContactoMail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Str;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Mail\EmailVerificationMail;
use Illuminate\Support\Facades\Log;



class EmailController extends Controller
{

    public function enviarCorreo(Request $request)
    {

        $existe = User::where('email', $request->email)->exists();

        if ($existe) {
            $numero = rand(1000, 9999);
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
        $user = User::where('email', operator: $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'El correo no está registrado.'], 404);
        }

        // Actualizar la contraseña
        $user->password = Hash::make($request->new_password);  // Hash para encriptar la nueva contraseña
        $user->save();

        return response()->json(['message' => 'Contraseña actualizada correctamente.'], 200);
    }







    public function verifyEmail(Request $request)
    {
        $email = $request->input('email'); // Recibir el correo desde el formulario

        // Validar formato de correo
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return response()->json(['message' => 'Formato de correo electrónico inválido'], 400);
        }

        // Verificar si el dominio tiene registros MX activos
        $domain = explode('@', $email)[1];
        if (!$this->checkDomainMX($domain)) {
            return response()->json(['message' => 'El dominio del correo no tiene registros MX o es inválido.'], 400);
        }
        // Verificar que el correo exista en la base de datos
        $user = User::where('email', operator: $request->email)->first();

        // Generar un token único para el correo
        $token = Str::random(60);
        if (!$user) {

            // Guardar temporalmente el token en la tabla email_verifications
            \DB::table('email_verifications')->insert([
                'email' => $email,  // Guardamos el correo temporalmente
                'token' => $token,
            ]);

            // Enviar el correo de verificación
            Mail::to($email)->send(new EmailVerificationMail($token));

            return response()->json(['message' => 'Correo de verificación enviado. Por favor, revisa tu bandeja de entrada.', 'acceso' => false], 200);
        } else {
            return response()->json(['message' => 'El correo ya se encuentra autenticado.', 'acceso' => true], 200);

        }
    }

    // Función para verificar si el dominio tiene registros MX
    private function checkDomainMX($domain)
    {
        $dnsRecords = dns_get_record($domain, DNS_MX);

        return !empty($dnsRecords);
    }

    // Función para verificar el token de verificación
    public function verifyToken($token)
    {
        // Buscar el token en la tabla email_verifications
        $verification = \DB::table('email_verifications')->where('token', $token)->first();

        if ($verification) {
            // Registrar al usuario en la tabla 'users' si el correo es verificado
            $user = User::create([
                'email' => $verification->email,  // Crear el usuario con el correo verificado
                'email_verified_at' => now(),     // Marcar el correo como verificado
            ]);

            // Eliminar el token de la base de datos
            \DB::table('email_verifications')->where('token', $token)->delete();
            return view('emails.success');

        }

        return response()->json(['message' => 'Token inválido.'], 400);
    }




    public function enviarPdf(Request $request)
    {
        try {
            $request->validate([
                'archivo' => 'required|file|mimes:pdf|max:2048',
                'email' => 'required|email',
            ]);

            $path = $request->file('archivo')->store('public/temp');
            $fullPath = storage_path('app/' . $path);

            // Enviar correo
            Mail::to($request->email)->send(new VentaPdfMail($fullPath));

            \Storage::delete($path);

            return response()->json(['message' => 'PDF enviado exitosamente al correo.']);

        } catch (\Throwable $e) {
            Log::error('Error al enviar PDF: ' . $e->getMessage());
            return response()->json([
                'error' => 'Ocurrió un error al enviar el PDF.',
                'details' => $e->getMessage()
            ], 500);
        }
    }




    public function enviarPdfCotizacion(Request $request)
    {
        try {
            $request->validate([
                'archivo' => 'required|file|mimes:pdf|max:2048',
                'email' => 'required|email',
            ]);

            $path = $request->file('archivo')->store('public/temp');
            $fullPath = storage_path('app/' . $path);

            // Enviar correo
            Mail::to($request->email)->send(new CotizacionPdfMail($fullPath));

            \Storage::delete($path);

            return response()->json(['message' => 'PDF enviado exitosamente al correo.']);

        } catch (\Throwable $e) {
            Log::error('Error al enviar PDF: ' . $e->getMessage());
            return response()->json([
                'error' => 'Ocurrió un error al enviar el PDF.',
                'details' => $e->getMessage()
            ], 500);
        }
    }

}

