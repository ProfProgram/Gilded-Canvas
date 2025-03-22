<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Models\Product;

class productListing extends Controller
{
    public function index(Request $request)
    {
        $query = request('query');
        $category = request('category');
        $minPrice = request('min_price');
        $maxPrice = request('max_price');
    
        // Start the query
        $productsQuery = Product::with('inventory');
    
        // Apply filters dynamically
        if ($query) {
            $productsQuery->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('product_name', 'like', '%' . $query . '%')
                            ->orWhere('category_name', 'like', '%' . $query . '%');
            });
        }
    
        if ($category) {
            $productsQuery->where('category_name', $category);
        }
    
        if ($minPrice !== null) {
            $productsQuery->where('price', '>=', $minPrice);
        }
    
        if ($maxPrice !== null) {
            $productsQuery->where('price', '<=', $maxPrice);
        }
    
        // Get the filtered products
        $filteredProducts = $productsQuery->get();
    
        return view('product', ['productInfo' => $filteredProducts]);
    }
    
}
