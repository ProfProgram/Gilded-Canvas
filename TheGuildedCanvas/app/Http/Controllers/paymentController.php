<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use App\Models\OrderDetail;
use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        if (!Auth::check()) {
            return redirect()->route('sign-in')->with('status', 'Please log in to access payment procedure.');
        }
        $userId = Auth::user()->user_id;
        $cartInfo = Cart::with('product')->where('cart_table.user_id', '=', $userId)->get();
        return view('payment', ['cartInfo'=>$cartInfo, 'total_price'=>$request->totalPrice]);
    }

    // Payment functionality is dummy/prototype - does not store card data or process any transaction.
    // This is intended to be for show and will clear cart and move its values to orders table in appropriate fashion
    public function store(Request $request) {
        $userId = Auth::user()->user_id;
        $cartItems = Cart::where('user_id', $userId)->get();
        
        $order = new Order;
        $order->admin_id = null;
        $order->user_id = $userId;
        $order->total_price = $request->totalPrice;
        $order->status = 'pending';

        try {
            if ($order->save()) {
                $order_id = $order->order_id;
                Log::info('Order saved successfully. Order ID: ' . $order_id);

                foreach ($cartItems as $cartItem) {
                    Log::info('Creating OrderDetail for Order ID: ' . $order_id);
                    OrderDetail::create([
                        'order_id' => $order_id,
                        'product_id' => $cartItem->product_id,
                        'quantity' => $cartItem->quantity,
                        'price_of_order' => $cartItem->price,
                    ]);
                    $product = Inventory::where('product_id', $cartItem->product_id)->firstOrFail();
                    try {
                        if ($product->update([
                            'stock_outgoing' => $product->stock_outgoing + $cartItem->quantity,
                        ])) {
                            Log::info("Product ID : {$product->product_id} stock outgoing updated to : {$product->stock_outgoing}");
                        }
                    } catch (\Exception $e) {
                        Log::info('Error: when updating inventory_table : '. $e->getMessage());
                        return redirect()->back()->with('status', 'Stocks could not be updated');
                    }
                }

                Cart::where('user_id', $userId)->delete();
                
                return redirect()->route( 'home')->with('status', "Payment made successfully. Order id:  {$order_id}");
            } else {
                return redirect()->back()->with('status', 'Order could not be made');
            }
        } catch (\Exception $e) {
            Log::info('Error: When saving order : ' . $e->getMessage());
            return redirect()->back()->with('status', 'Error: Order could not be made');
        }
    }
}
