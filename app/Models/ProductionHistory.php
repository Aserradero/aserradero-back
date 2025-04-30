<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'coeficiente', 
        'm3TRM',
        'identificadorP',
        'user_id',
        'fechaFinalizacion', 
        'piesTablaTP',
        
    ];
}
