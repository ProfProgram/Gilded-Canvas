<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Admin;
use App\Models\Inventory;
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
            $returnProducts = DB::table('returns_table')
                ->where('order_id', $order->order_id)
                ->get()
                ->pluck('product_id')
                ->toArray();
            
            return [
                'order_id' => $order->order_id,
                'order_time' => $order->order_time,
                'status' => $order->status,
                'total_price' => $order->total_price,
                'admin_name' => optional($order->admin)->user->name ?? 'Not yet assigned.',
                'products' => $order->details->map(function ($detail) use ($returnProducts) {
                    $isReturned = in_array($detail->product_id, $returnProducts);
                    return [
                        'product_id' => optional($detail->product)->product_id ?? null,
                        'product_name' => optional($detail->product)->product_name ?? 'Unknown Product',
                        'quantity' => $detail->quantity,
                        'price_of_order' => $detail->price_of_order,
                        'is_returned' => $isReturned,
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

//     Issue with updateStatus
//     if admin updates status to 'shipped' or 'delivered' the inventory stock out will update - this is intended
//     if they update back to 'pending' then back to 'shipped' or 'delivered' then the stock out will increase again - this is not intended
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,shipped,delivered,cancelled',
        ]);

        $userId = Auth::user()->user_id;
        $adminId = Admin::where('user_id', $userId)->value('admin_id');
        
        $order = Order::with('details')->where('order_id', $id)->firstOrFail();
        
        try {
            if ($order->update(['status' => $request->status, 'admin_id' => $adminId])) {
                
                // Proceed only if the order status is not 'pending' or 'cancelled'
                if (!in_array($order->status, ['pending', 'cancelled'])) {
                    try {
                        // Loop through the related order details to update inventory
                        foreach ($order->details as $orderDetail) {
                            $product = Inventory::where('product_id', $orderDetail->product_id)->firstOrFail();

                            if ($product->update(['stock_outgoing' => $product->stock_outgoing + $orderDetail->quantity])) {
                                Log::info("Product ID: {$product->product_id} stock outgoing updated to: {$product->stock_outgoing}");
                            }
                        }
                    } catch (\Exception $e) {
                        Log::error("Error updating inventory_table for Product ID: {$orderDetail->product_id}. {$e->getMessage()}");
                        return redirect()->back()->with('status', 'Stocks could not be updated');
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error("Failed to update Order: {$id}. {$e->getMessage()}");
            return redirect()->back()->with('status', "Order: {$id} status could not be updated.");
        }
        
        return redirect()->route('admin.orders')->with('status', 'Order status updated successfully!');
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->back()->with('status', "Order : {$id} DELETED.");
    }
    public function showReturnRequestForm($order_id)
{
    if (!Auth::check()) {
        return redirect()->route('sign-in')->with('status', 'Please log in to request a return.');
    }

    $user_id = Auth::id();

    $order = DB::table('orders_table')->where('order_id', $order_id)->first();

    if (!$order) {
        return redirect()->route('previous-orders')->with('status', 'Order not found.');
    }

    // Check if the return request exists
    $existingReturn = DB::table('returns_table')
        ->where('order_id', $order_id)
        ->where('user_id', $user_id)
        ->first();

    return view('return-form', [
        'order_id' => $order_id,
        'return_status' => $existingReturn ? 'pending' : 'not_requested',
        'orderDetails' => DB::table('orders_details_table')
            ->where('order_id', $order_id)
            ->join('products_table', 'orders_details_table.product_id', '=', 'products_table.product_id')
            ->select('orders_details_table.product_id', 'products_table.product_name', 'orders_details_table.quantity')
            ->get()
    ]);
}

public function submitReturnRequest(Request $request, $order_id)
{
    if (!Auth::check()) {
        return redirect()->route('sign-in')->with('status', 'Please log in to submit a return request.');
    }

    $user_id = Auth::id();

    // Check if the return request already exists
    $existingReturn = DB::table('returns_table')
        ->where('order_id', $order_id)
        ->where('user_id', $user_id)
        ->first();
    $order = Order::where('order_id', $order_id)
                  ->where('user_id', Auth::id())
                  ->first();

    if (!$order) {
        return redirect()->route('previous-orders')->with('status', 'Order not found.');
    }

    // Check if a return request already exists
    $existingReturn = DB::table('returns_table')
                        ->where('order_id', $order_id)
                        ->where('user_id', Auth::id())
                        ->where('status', 'pending')
                        ->exists();

    if ($existingReturn) {
        return redirect()->route('return.request', ['order_id' => $order_id])
            ->with('message', 'Your return request has already been submitted and is pending.');
    }

    // Validate request
    $request->validate([
        'reason' => 'required|string',
        'product_ids' => 'required|array',
        'return_quantities' => 'required|array',
    ]);

    $products = $request->input('product_ids');
    $quantities = $request->input('return_quantities');

    foreach ($products as $product_id) {
        $quantityToReturn = isset($quantities[$product_id]) ? (int)$quantities[$product_id] : 0;

        if ($quantityToReturn > 0) {
            DB::table('returns_table')->insert([
                'order_id' => $order_id,
                'user_id' => Auth::id(),
                'product_id' => $product_id,
                'quantity' => $quantityToReturn,
                'reason' => $request->input('reason'),
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    return redirect()->route('home')->with('message', 'Your return request has been submitted.');
}

}
