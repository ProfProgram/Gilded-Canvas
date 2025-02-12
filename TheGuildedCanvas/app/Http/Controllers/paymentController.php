<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;

class paymentController extends Controller
{
    public function index(Request $request) {
        // $orderInfo = Order::where('user_id', 1)->latest('order_time')->first();
        // if ($orderInfo) {
        //     $orderDetail = OrderDetail::where('order_id', $orderInfo->order_id)->get();
        
        // return view('payment' , ['orderDetail'=>$orderDetail]);
        // } else {
        //     return view('payment', ['orderDetail'=>null]);
        // }
        $userId = Auth::user()->user_id;
        $cartInfo = Cart::with('product')->where('cart_table.user_id', '=', $userId)->get();
        return view('payment', ['cartInfo'=>$cartInfo, 'total_price'=>$request->totalPrice]);
    }

    public function store(Request $request) {
        return redirect()->back();
    }
}
