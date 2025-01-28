<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Http\Request;

class IndivProductController extends Controller
{
    // will handle all data interactions on indivProduct view
    public function index() {
        // Tables needed for view :: Product; Inventory
        $products = Product::all();
        $inventory = Inventory::all();
        return view('indivProduct', compact('products', 'inventory'));
    }
}
