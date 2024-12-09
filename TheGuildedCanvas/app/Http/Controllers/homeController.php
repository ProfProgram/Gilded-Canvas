<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class homeController extends Controller
{
    public function index()
    {
        $productInfo = Product::all();
        return view('home', ['productInfo'=>$productInfo]);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        // Search products by name or category
        $products = Product::where('product_name', 'LIKE', "%{$query}%")
            ->orWhere('category_name', 'LIKE', "%{$query}%")
            ->get();

        return view('home', ['productInfo' => $products, 'query' => $query]);
    }
}
