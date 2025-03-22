<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'rating',
        'ease_of_use',
        'checkout_process',
        'product_info',
        'delivery_experience',
        'customer_support',
        'best_feature',
        'improvement_area',
        'recommend',
        'review_text',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
