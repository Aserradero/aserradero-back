<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $datos;

    public function __construct($datos)
    {
        $this->datos = $datos;
    }

    public function build()
    {
        return $this->from('unidadecosanmateo@uniecosanmateo.icu', 'Unidad Eco San Mateo')
            ->subject('Nuevo Mensaje de Contacto')
            ->view('emails.contacto')
            ->with('datos', $this->datos);
    }
}
