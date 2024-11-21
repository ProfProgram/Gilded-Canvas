<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'Orders Details Table';

    protected $fillable = [
        'Order_id',
        'Product_id',
        'Quantity',
        'Price_of_order',
    ];

    /**
     * Below are all connects of this Model
     * Each Detail is about 1 product from within 1 order
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}