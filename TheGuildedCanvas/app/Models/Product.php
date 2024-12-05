<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products_table';

    protected $fillable = [
        'Category_name',
        'Description',
        'image_path',
        'caption',
        'genre',
        'price',
        'is_featured',
        'is_new'
    ];
}
