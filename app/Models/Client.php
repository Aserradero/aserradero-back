<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombreCliente',
        'apellidosCliente',
        'rfc',
        'telefono',
        'direccion',
        'correoElectronico'
    ];

    public function bill(){
        return $this->hasMany(Bill::class);
    }

}
