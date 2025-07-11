<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'precio',
        'calidad',
        'cantidad',
        'ancho',
        'grosor',
        'largo',
        'piesTabla',
        'fechaRegistro',
        'identificadorP',
        'idCatalogProduct'
    ];

   public function catalogProduct()
    {
        return $this->belongsTo(CatalogProduct::class, 'idCatalogProduct');
    }
    public function productSales()
    {
    return $this->hasMany(ProductSale::class, 'producto_id');
    }
}
