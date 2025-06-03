<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatalogProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'grosor',
        'ancho',
        'largo',
        'tipoProducto',
        'codigoProducto',
        'precioUnitario'
        // Agrega aquí todos los campos que permitirás asignar masivamente
    ];
}
