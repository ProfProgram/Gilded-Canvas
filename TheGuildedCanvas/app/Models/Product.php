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
        'category_name',
        'product_name',
        'price',
        'height',
        'width',
        'description',
    ];

    public function reviews() {
        return $this->hasMany(Review::class, 'Product_id');
    }

    public function inventory()
{
    return $this->hasOne(Inventory::class, 'product_id');
}
}