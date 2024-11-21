<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    use HasFactory;

    protected $table = 'orders_details_table';
    protected $primaryKey = 'Order_detail_id';

    protected $fillable = [
        'Order_id',
        'Product_id',
        'Quantity',
        'Price_of_order',
    ];
}