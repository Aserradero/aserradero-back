<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExitNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'metroCT',
        'fechaEmision',
        'nombreUsuario'
     ];
}
