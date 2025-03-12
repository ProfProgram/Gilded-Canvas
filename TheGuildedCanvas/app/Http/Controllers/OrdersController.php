<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    public function index() {
        if (!Auth::check()) {
            return redirect()->route('sign-in')->with('status', 'Please log in to view your previous orders.');
        }
        $userId = Auth::user()->user_id;
        $orderInfo = Order::join('orders_details_table', 'orders_details_table.order_id', '=', 'orders_table.order_id')
        ->join('users_table AS customer', 'customer.user_id', '=', 'orders_table.user_id')
        ->leftJoin('admin_table', 'admin_table.admin_id', '=', 'orders_table.admin_id')
        ->leftJoin('users_table AS admin', 'admin.user_id', '=', 'admin_table.user_id')
        ->join('products_table', 'products_table.product_id', '=', 'orders_details_table.product_id')
        ->where('orders_table.user_id', $userId)
        ->select(
            'orders_table.order_id', 
            'orders_table.order_time', 
            'orders_table.status', 
            'orders_table.admin_id', 
            'customer.name AS customer_name',
            'admin.name AS admin_name',
            'orders_table.total_price',
            'orders_details_table.product_id', 
            'orders_details_table.quantity', 
            'orders_details_table.price_of_order',
            'products_table.product_name'
        )
        ->get();
        return view('/previous-orders', ['orders'=>$orderInfo]);
    }
    public function manage()
    {
        $orders = DB::table('orders_table')
            ->join('users_table AS customer', 'customer.user_id', '=', 'orders_table.user_id')
            ->join('orders_details_table', 'orders_details_table.order_id', '=', 'orders_table.order_id')
            ->join('products_table', 'products_table.product_id', '=', 'orders_details_table.product_id')
            ->select(
                'orders_table.order_id',
                'orders_table.order_time',
                'orders_table.total_price',
                'orders_table.status',
                'customer.name AS customer_name',
                'orders_details_table.product_id',
                'orders_details_table.quantity',
                'orders_details_table.price_of_order',
                'products_table.product_name'
            )
            ->orderBy('orders_table.order_id', 'DESC')
            ->get();

        return view('admin.orders', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,shipped,delivered,cancelled',
        ]);

        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Order status updated successfully!',
        ]);
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return response()->json(['success' => true]);
    }
}
