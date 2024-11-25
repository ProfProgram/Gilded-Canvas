<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'Inventory Table';

    protected $fillable = [
        'Product_id',
        'Admin_id',
        'Stock_in',
        'Stock_out',
        'Stock_level',
    ];


    /**
     * Below are all connects of this Model
     * Each inventory was made by 1 admin and refers to 1 products stocks
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}