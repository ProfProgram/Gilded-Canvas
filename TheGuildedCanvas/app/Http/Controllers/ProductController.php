<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() {
        $products = Product::all(); // Fetch all products
        return view('home', compact('products')); // Pass products to the view
    }
    public function search(Request $request) {
        $query = $request->input('query');
        $products = product::where('name', 'LIKE', "%$query%")->get();
        return view('home', compact('products'));
    }
    public function show($id) {
        $product = Product::where('product_id', $id)->firstOrFail();
        return view('product', compact('product'));
    }

}
