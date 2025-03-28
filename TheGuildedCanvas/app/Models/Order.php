<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders_table';
    protected $primaryKey = 'order_id';
    public $timestamps = false; 

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
        return $this->belongsTo(User::class, 'user_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function details()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'order_id');
    }
}