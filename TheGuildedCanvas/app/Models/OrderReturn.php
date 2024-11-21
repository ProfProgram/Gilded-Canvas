<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderReturn extends Model
{
    use HasFactory;

    protected $table = 'Returns Table';

    protected $fillable = [
        'Order_id',
        'Product_id',
        'User_id',
        'Admin_id',
        'Return_reason',
        'Return_status',
        'Return_date'
    ];

    /**
     * Below are all connects of this Model
     * Each 
     */

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(admin::class);
    }
}