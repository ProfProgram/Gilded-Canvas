<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class IndivProductController extends Controller
{
    // will handle all data interactions on indivProduct view
    public function index($productName) {
        // Tables needed for view :: Product; Inventory
        $normalizedName = Str::of($productName)->lower()->replace('-', ' ');
        $product = Product::whereRaw('LOWER(product_name) = ?', [$normalizedName])->firstOrFail();
        $inventory = Inventory::where('product_id', $product->product_id)->firstOrFail();
        $reviews = Review::join('users_table', 'users_table.user_id', '=', 'reviews_table.user_id')
                    ->join('products_table', 'products_table.product_id', '=', 'reviews_table.product_id')
                    ->where('reviews_table.product_id' , $product->product_id)
                    ->select('reviews_table.*', 'users_table.name', 'products_table.product_name')->get();
        return view('indivProduct', ['productInfo'=>$product, 'inventoryInfo'=>$inventory, 'reviewInfo'=>$reviews]);
    }
}
