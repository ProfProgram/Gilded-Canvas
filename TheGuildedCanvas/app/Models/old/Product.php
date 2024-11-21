<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products_table';
    protected $primaryKey = 'Products_id';

    protected $fillable = [
        'Category_id',
        'Stock_level',
        'Product_image',
        'Description',
    ];
}
