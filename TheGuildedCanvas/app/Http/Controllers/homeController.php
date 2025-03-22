<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class homeController extends Controller
{
    public function index(Request $request)
    {
        $productInfo = Product::all();
        $reviews = WebsiteReview::latest()->take(3)->get();
    
        return view('home', [
            'productInfo' => $productInfo,
            'reviews' => $reviews
        ]);
    }
    
}
