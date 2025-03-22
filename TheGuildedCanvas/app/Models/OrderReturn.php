<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderReturn extends Model
{
    use HasFactory;

    protected $table = 'returns_table';

    protected $primaryKey = 'return_id';

    protected $fillable = [
        'order_id',
        'product_id',
        'user_id',
        'reason',
        'status',
    ];

    /**
     * Below are all connects of this Model
     * Each 
     */

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}