<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Inventory;
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
            return redirect()->route('sign-in')->with('status', 'Please log in to view your basket.');
        }
        $userId = Auth::user()->user_id;
        $cartItems = Cart::with('product')->with( 'user')->where('user_id', '=', $userId)->get();
        return view('basket', ['cartItems'=>$cartItems]);
    }

    public function delete($id)
    {
        if (!Auth::check()) {
            return redirect()->route('sign-in')->with('status', 'Please log in to delete from basket.');
        }
        $cart = Cart::with('product')->where('basket_id', $id)->first();
        $prod_name = $cart->product->product_name;
        $cart->delete();
        return redirect()->back()->with('status', 'Removed '.$prod_name.' from your cart');
    }
    public function add(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('sign-in')->with('status', 'Please log in to add to basket.');
        }
        $userId = Auth::user()->user_id;

        $productId = $request->input('product_id');
        $productName = $request->input('product_name');
        $productPrice = $request->input('product_price');
        $quantity = $request->input('cartQuan_add');
        
        // Check if the product already exists in the cart (for the current user)
        $existingCartItem = Cart::where('product_id', $productId)
                                ->where('user_id', $userId)  // Assuming you're using authentication
                                ->first();

        if ($existingCartItem) {
            // Product exists in the cart, increment the quantity
            $existingCartItem->quantity += $quantity;
            $existingCartItem->save();
        } else {
            Cart::create([
                'product_id' => $productId,
                'user_id' => $userId,
                'product_name' => $productName,
                'price' => $productPrice,
                'quantity' => $quantity,
            ]);
        }

        return redirect()->back()->with('status', $productName.' added to cart!');
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
        if (!Auth::check()) {
            return redirect()->route('sign-in')->with('status', 'Please log in to view your previous orders.');
        }
        $cart = Cart::with('product')->find($request->id);
        $inv_lvl = Inventory::where('product_id', $cart->product->product_id)->first();
        if ($request->quantity > $inv_lvl->stock_level) {
            return redirect()->route('basket')->with('status', 'Failed to update '.$cart->product->product_name.' quantity: Exceeds available stock');
        }
        $cart->quantity = $request->quantity;
        $cart->save();
        return redirect()->route('basket')->with('status', 'Updated '.$cart->product->product_name.' quantity to '.$cart->quantity);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        //
    }
}
