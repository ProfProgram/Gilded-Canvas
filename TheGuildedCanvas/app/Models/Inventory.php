<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventory_table';
    protected $primaryKey = 'inventory_id';

    protected $fillable = [
        'product_id',
        'admin_id',
        'stock_level',
        'stock_incoming',
        'stock_outgoing',
    ];


    /**
     * Below are all connects of this Model
     * Each inventory was made by 1 admin and refers to 1 products stocks
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id','product_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
