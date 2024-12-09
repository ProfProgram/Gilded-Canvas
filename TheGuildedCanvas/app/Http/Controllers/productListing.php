<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class productListing extends Controller
{
    public function index(Request $request)
    {
        $productInfo = Product::all();
        return view('product', ['productInfo' => $productInfo]);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        // Search products by name or category
        $products = Product::where('product_name', 'LIKE', "%{$query}%")
            ->orWhere('category_name', 'LIKE', "%{$query}%")
            ->get();

        return view('product', ['productInfo' => $products, 'query' => $query]);
    }
}
