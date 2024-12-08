<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use App\Models\OrderDetail;

class paymentController extends Controller
{
    public function index() {
        // $orderInfo = Order::where('user_id', 1)->latest('order_time')->first();
        // if ($orderInfo) {
        //     $orderDetail = OrderDetail::where('order_id', $orderInfo->order_id)->get();
        
        // return view('payment' , ['orderDetail'=>$orderDetail]);
        // } else {
        //     return view('payment', ['orderDetail'=>null]);
        // }
        $cartInfo = Cart::with('product')->get();
        return view('payment', ['cartInfo'=>$cartInfo]);
    }

    public function store(Request $request) {
        return redirect()->back();
    }
}
