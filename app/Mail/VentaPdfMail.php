<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VentaPdfMail extends Mailable
{
    use Queueable, SerializesModels;

    public $archivo;

    public function __construct($archivo)
    {
        $this->archivo = $archivo;
    }

    public function build()
    {
        return $this->subject('Factura de Compra')
            ->view('emails.factura') // esta es la vista que se renderiza en el correo
            ->attach($this->archivo, [
                'as' => 'Factura.pdf',
                'mime' => 'application/pdf',
            ]);
    }
}
