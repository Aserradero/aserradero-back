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
}
