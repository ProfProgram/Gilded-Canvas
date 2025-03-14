<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders_table';

    protected $fillable = [
        'admin_id',
        'user_id',
        'total_price',
        'status'
    ];

    /**
     * Below are all connects of this Model
     * Each Order is made by 1 User and is assigned to 1 Admin
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function details()
    {
        return $this->hasMany(OrderDetails::class, 'order_id', 'order_id');
    }
}