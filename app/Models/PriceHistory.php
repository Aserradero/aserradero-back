<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceHistory extends Model
{
    use HasFactory;
    protected $table = 'price_history';
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
