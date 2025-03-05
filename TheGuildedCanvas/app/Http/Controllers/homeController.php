<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class homeController extends Controller
{
    public function index(Request $request)
    {
        $productInfo = Product::all();
        return view('home', ['productInfo'=>$productInfo]);
    }
}
