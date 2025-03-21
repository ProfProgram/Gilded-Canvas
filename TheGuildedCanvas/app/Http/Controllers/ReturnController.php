<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReturnController extends Controller
{
 public function processReturn(Request $request)
    {
        $request->validate([
            'order_id' => 'required|integer',
            'product_ids' => 'required|array',
            'reason' => 'required|string|max:500',
            'return_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Ensure user is authenticated before proceeding
        if (!Auth::check()) { 
            return redirect()->route('home')->with('error', 'You must be logged in to submit a return request.');
        }

        $user_id = Auth::id(); 
        $imagePaths = [];

        if ($request->hasFile('return_images')) {
            foreach ($request->file('return_images') as $image) {
                $path = $image->store('return_images', 'public');
                $imagePaths[] = $path;
            }
        }

        // Insert multiple return requests for selected products
        foreach ($request->product_ids as $product_id) {
            DB::table('returns_table')->insert([
                'order_id' => $request->order_id,
                'product_id' => $product_id,
                'user_id' => $user_id, 
                'reason' => $request->reason,
                'images' => json_encode($imagePaths), 
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('home')->with('status', 'Return request submitted successfully!');
    }
    public function manageReturns()
    {
        $returns = DB::table('returns_table')
            ->join('orders_table', 'returns_table.order_id', '=', 'orders_table.order_id')
            ->join('users_table', 'orders_table.user_id', '=', 'users_table.user_id')
            ->join('products_table', 'returns_table.product_id', '=', 'products_table.product_id')
            ->select(
                'returns_table.return_id',  
                'orders_table.order_id',
                'returns_table.user_id',  // Fetching user_id instead of customer name
                'returns_table.product_id',
                'returns_table.quantity',
                'returns_table.reason',
                'returns_table.status',
                'returns_table.created_at'
            )
            ->orderBy('returns_table.created_at', 'desc')
            ->get();
    
        return view('admin.returns', compact('returns'));
    }
    
}
