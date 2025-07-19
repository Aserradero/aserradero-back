<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CotizacionPdfMail extends Mailable
{
    use Queueable, SerializesModels;

    public $archivo;

    public function __construct($archivo)
    {
        $this->archivo = $archivo;
    }

    public function build()
    {
        return $this->subject('Cotización')
            ->view('emails.cotizacion') // esta es la vista que se renderiza en el correo
            ->attach($this->archivo, [
                'as' => 'Cotizacion.pdf',
                'mime' => 'application/pdf',
            ]);
    }
}
