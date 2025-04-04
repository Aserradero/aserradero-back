<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductInventory extends Model
{
    use HasFactory;
    protected $fillable = [
       'idProducto',
       'precioUnitario',
       'stockIdealPT',
       'idUsuario'
    ];

     // Relación con el modelo Product
     public function product()
     {
         return $this->belongsTo(Product::class, 'idProducto'); // 'idProducto' es la clave foránea
     }
}
