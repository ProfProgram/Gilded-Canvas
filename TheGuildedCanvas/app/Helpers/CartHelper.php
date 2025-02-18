<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class CartHelper
{
    /**
     * Create a new class instance.
     */
    public static function getCartCount()
    {
        if (Auth::check()) {
            // For logged-in users
            return Cart::where('user_id', Auth::id())->count();
        }
    }
}
