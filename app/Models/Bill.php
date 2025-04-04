<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;
    protected $fillable = [
        'cantidad',
        'unidad',
        'descripcion',
        'subTotal',
        'IVA',
        'precioUnitario',
        'importeConcepto',
        'totalVenta',
        'datosCliente',
        'fechaCompra',
        'nombreUsuario',
        'sale_id',
        'user_id'
     ];
}
