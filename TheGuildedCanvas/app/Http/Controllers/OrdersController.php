<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
    public function manage(Request $request)
    {
        $query = DB::table('orders_table')
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
            );
    
        if ($request->has('search') && !empty($request->search)) {
            $query->where(function ($q) use ($request) {
                $q->where('orders_table.order_id', 'LIKE', "%{$request->search}%")
                  ->orWhere('customer.name', 'LIKE', "%{$request->search}%");
            });
        }
    
       
        if ($request->has('status_filter') && !empty($request->status_filter)) {
            $query->where('orders_table.status', $request->status_filter);
        }
    
        $orders = $query->orderBy('orders_table.order_id', 'DESC')->get();
    
        return view('admin.orders', compact('orders'));
    }
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,shipped,delivered,cancelled',
        ]);
    
       
        $order = Order::where('order_id', $id)->firstOrFail();
    
        $order->update(['status' => $request->status]);
    
        return redirect()->route('admin.orders')->with('status', 'Order status updated successfully!');
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return response()->json(['success' => true]);
    }