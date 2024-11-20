<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders_table';
    protected $primaryKey = 'Order_detail';

    protected $fillable = [
        'Total_price',
        'Order_data',
        'Admin_id',
        'User_id',
        'Status',
    ];
}