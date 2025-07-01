<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrecieHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'precio',
        'calidad',
        'ancho',
        'grosor', 
        'largo',
        'fechaRegistro',
        'fechaActualizada',
        'idUsuario'
    ];
}
