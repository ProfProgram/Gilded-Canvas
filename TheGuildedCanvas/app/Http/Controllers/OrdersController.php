<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; 

class OrdersController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('sign-in')->with('status', 'Please log in to view your previous orders.');
        }

        $userId = Auth::user()->user_id;

        $orders = Order::with(['details.product', 'admin.user'])
        ->where('user_id', $userId)
        ->get()
        ->map(function ($order) {
            return [
                'order_id' => $order->order_id,
                'order_time' => $order->order_time,
                'status' => $order->status,
                'total_price' => $order->total_price,
                'admin_name' => optional($order->admin)->user->name ?? 'Not yet assigned.',
                'products' => $order->details->map(function ($detail) {
                    return [
                        'product_id' => optional($detail->product)->product_id ?? null,
                        'product_name' => optional($detail->product)->product_name ?? 'Unknown Product',
                        'quantity' => $detail->quantity,
                        'price_of_order' => $detail->price_of_order
                    ];
                })->toArray(),
            ];
        });
    

        return view('/previous-orders', ['orders' => $orders]);
    }

    public function manage(Request $request)
    {
        // User checks for managing access to view
        if (!Auth::check()) {
            return redirect()->route('sign-in')->with('status', 'Please log in to view your previous orders.');
        }

        if (auth()->user()->role !== \App\Enums\UserRole::admin) {
            return redirect('/home')->with('status', 'You do not have access to this page.');
        }
        
        
        //  Ensure products appear under a single order row
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
            DB::raw("GROUP_CONCAT(products_table.product_name SEPARATOR ', ') AS product_names"),
            DB::raw("GROUP_CONCAT(orders_details_table.quantity SEPARATOR ', ') AS product_quantities"),
            DB::raw("GROUP_CONCAT(orders_details_table.price_of_order SEPARATOR ', ') AS product_prices")
        )
        ->groupBy(
            'orders_table.order_id',
            'orders_table.order_time',
            'orders_table.total_price',
            'orders_table.status',
            'customer.name'
        ); //  Ensure only one row per order

        // **Apply Search Filter**
        if ($request->has('search') && !empty($request->search)) {
            $query->where(function ($q) use ($request) {
                $q->where('orders_table.order_id', 'LIKE', "%{$request->search}%")
                  ->orWhere('customer.name', 'LIKE', "%{$request->search}%");
            });
        }

        // **Apply Status Filter**
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

        $userId = Auth::user()->user_id;
        $adminId = Admin::with('user')->where('user_id', $userId)->value('admin_id');

        //  Ensure that updating status applies to the whole order, not individual items
        $order = Order::where('order_id', $id)->firstOrFail();
        $order->update(['status' => $request->status]);

        try {
            if ($order->update(['admin_id' => $adminId])) {

            }
            else {
                return redirect()->back()->with('status', 'Admin ID could not be updated.');
            }
        } catch (\Exception $e) {
            Log::error('Failed to update admin_id on Order: '.$id.'' . $e->getMessage());
            return redirect()->back()->with('status','Failed to update admin_id on Order: '.$id.'. ' . $e->getMessage() . ' Please contact us for more help.') ;
        }

        return redirect()->route('admin.orders')->with('status', 'Order status updated successfully!');
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->back()->with('status', "Order : {$id} DELETED.");
    }
}
