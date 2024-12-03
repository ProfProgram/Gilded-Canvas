<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;

class paymentController extends Controller
{
    public function index() {
        $orderInfo = Order::where('User_id', 1)->latest('Order_time')->first();
        if ($orderInfo) {
            $orderDetail = OrderDetail::where('Order_id', $orderInfo->Order_id)->get();
        
        return view('payment' , ['orderDetail'=>$orderDetail]);
        } else {
            return view('payment', ['orderDetail'=>null]);
        }
    }

    public function store(Request $request) {
        return redirect()->back();
    }
}
