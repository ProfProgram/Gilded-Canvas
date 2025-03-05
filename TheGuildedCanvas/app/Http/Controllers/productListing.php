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
        $category = $request->input('category');

        // Search products by name or category
        $products = Product::all();

        return view('product', [
            'productInfo' => $products,
            'query' => $query,
            'category' => $category
        ]);
    }
}
