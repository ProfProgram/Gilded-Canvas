<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'Reviews Table';

    protected $fillable = [
        'User_id',
        'Product_id',
        'Rating',
        'Review_text',
    ];

    protected function casts(): array
    {
        return [
            'Review_date' => 'datetime',
        ];
    }

    /**
     * Below are all connects of this Model
     * Each review is made by 1 user and is about 1 product
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'Product_id');
    }
}