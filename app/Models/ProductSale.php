<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSale extends Model
{
    use HasFactory;
    protected $fillable = [
        'cantidad',
        'producto_id',
        'sale_id'
        
     ];
}
