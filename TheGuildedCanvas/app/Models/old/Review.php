<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'reviews_table';
    protected $primaryKey = 'Review_id';

    protected $fillable = [
        'Product_id',
        'User_id',
        'Rating',
        'Review',
    ];
}
