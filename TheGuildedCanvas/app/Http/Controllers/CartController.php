<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('sign-in')->with('message', 'Please log in to view your previous orders.');
        }
        $userId = Auth::user()->user_id;
        $cartItems = Cart::with('product')->with( 'user')->where('user_id', '=', $userId)->get();
        return view('basket', ['cartItems'=>$cartItems]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    public function delete($id)
    {
        $cart = Cart::where('basket_id', $id);
        $cart->delete();
        return redirect()->back()->with('status', 'Data Deleted');
    }
    public function add(Request $request)
    {
        $productId = $request->input('product_id');
        $productName = $request->input('product_name');
        $productPrice = $request->input('product_price');
        $quantity = $request->input('cartQuan_add');
        
        // Check if the product already exists in the cart (for the current user)
        $existingCartItem = Cart::where('product_id', $productId)
                                ->where('user_id', 1)  // Assuming you're using authentication
                                ->first();

        if ($existingCartItem) {
            // Product exists in the cart, increment the quantity
            $existingCartItem->quantity += $quantity;
            $existingCartItem->save();
        } else {
            // Product doesn't exist in the cart, create a new cart entry
            Cart::create([
                'product_id' => $productId,
                'user_id' => 1, // Assuming you're using authentication
                'product_name' => $productName,
                'price' => $productPrice,
                'quantity' => $quantity, // Start with 1 quantity
            ]);
        }

        // Optionally, redirect back to the product page or cart page
        return redirect()->back()->with('success', 'Product added to cart!');
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        //
    }
}
