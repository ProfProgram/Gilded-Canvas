<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventory_table';
    protected $primaryKey = 'Inventory_id';

    protected $fillable = [
        'Product_id',
        'Admin_id',
        'Stock_in',
        'Stock_out',
        'Current_stock',
        'Threshold_level',
    ];
}