<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;
    protected $fillable = [
        'piesTablaTotal',
        'nombreCliente',
        'rfc',
        'telefono',
        'direccion',
        'importeLetra',
        'tipoVenta',
        'subtotal',
        'iva',
        'total',
        'sale_id',
        'user_id'
    ];
}
