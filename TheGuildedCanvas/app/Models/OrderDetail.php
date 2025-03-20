<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'orders_details_table';

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price_of_order',
    ];

    /**
     * Below are all connects of this Model
     * Each Detail is about 1 product from within 1 order
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}