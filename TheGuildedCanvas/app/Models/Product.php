<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products_table';

    protected $primaryKey = 'product_id';


    protected $fillable = [
        'category_name', 'description', 'image_path', 'caption', 'genre',
        'price', 'is_featured', 'is_new'
    ];
}
