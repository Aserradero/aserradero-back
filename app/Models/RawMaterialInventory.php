<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RawMaterialInventory extends Model
{
    use HasFactory;
    protected $fillable = [
        'stockIdeal',
        'idUsuario'
     ];

    
     // Relación con el modelo Product
     public function rawmaterial()
     {
         return $this->belongsTo(RawMaterial::class, 'idMateria'); // 'idProducto' es la clave foránea
     }
}
