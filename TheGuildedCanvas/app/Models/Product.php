<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'Products Table';

    protected $fillable = [
        'Category_name',
        'Product_name',
        'Description',
    ];

    public function reviews() {
        return $this->hasMany(Review::class, 'Product_id');
    }
}