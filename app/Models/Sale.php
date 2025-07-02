<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $fillable = [
        'idUsuario'
    ];


    public function productSales()
    {
        return $this->hasMany(ProductSale::class, 'sale_id');
    }

    public function bill()
    {
        return $this->hasOne(Bill::class, 'sale_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'idUsuario');
    }
}
