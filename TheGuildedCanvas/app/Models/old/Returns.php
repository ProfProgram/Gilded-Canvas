<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Returns extends Model
{
    use HasFactory;

    protected $table = 'returns_table';
    protected $primaryKey = 'Return_id';

    protected $fillable = [
        'Order_id',
        'Product_id',
        'User_id',
        'Admin_id',
        'Return_reason',
        'Return_status',
        'Return_date',
    ];
}
