<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart_table';
    protected $primaryKey = 'basket_id';
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'price',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function product()
{
    return $this->belongsTo(Product::class, 'product_id', 'product_id');
}
}
