<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;

class InventoryController extends Controller
{
    public function index()
    {
        // Check if user is logged in first or role will read as null throwing error
        // Ensure the user is an admin
        if (!Auth::check()) {
            return redirect()->route('sign-in')->with('status', 'Please log in to view.');
        }
        if (auth()->user()->role !== \App\Enums\UserRole::admin) {
            return redirect('/home')->with('status', 'You do not have access to this page.');
        }
    // Fetch all inventory items with their associated products
        $inventory = Inventory::with('product')->get();

    // Fetch all products for the dropdown
        return view('admin.inventory', compact('inventory'));
    /*$products = Product::all();

    return view('admin.inventory', [
        'inventory' => $inventory,
        'products' => $products,
    ]);*/
}

    public function update(Request $request, $id)
    {
        // Ensure the user is an admin
        if (auth()->user()->role !== \App\Enums\UserRole::admin) {
            return redirect('/home')->with('status', 'You do not have access to this page.');
        }


        // Validate the request data
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products_table,product_id',
            'stock_level' => 'required|integer',
        ]);

        //dd($validatedData);

        // Find the inventory item by ID
        $inventory = Inventory::findOrFail($id);

        //dd($inventory);



        // Update the inventory item
        $inventory->update([
            'product_id' => $request['product_id'],
            'stock_level' => $validatedData['stock_level'],
            'admin_id' => Admin::where('user_id', Auth::id())->value('admin_id'), // Update the admin who made the change
        ]);

        //dd($inventory);

        return redirect()->route('admin.inventory')->with('status', 'Inventory item updated successfully!');
    }
    public function updateIncoming(Request $request, $id)
    {
        // Ensure the user is an admin
        if (auth()->user()->role !== \App\Enums\UserRole::admin) {
            return redirect('/home')->with('status', 'You do not have access to this page.');
        }


        // Validate the request data
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products_table,product_id',
            'stock_incoming' => 'required|integer',
        ]);

        //dd($validatedData);

        // Find the inventory item by ID
        $inventory = Inventory::findOrFail($id);

        //dd($inventory);



        // Update the inventory item
        $inventory->update([
            'product_id' => $request['product_id'],
            'stock_incoming' => $validatedData['stock_incoming'],
            'admin_id' => Admin::where('user_id', Auth::id())->value('admin_id'), // Update the admin who made the change
        ]);

        //dd($inventory);

        return redirect()->route('admin.inventory')->with('status', 'Inventory item incoming stock updated successfully!');
    }
    public function updateOutgoing(Request $request, $id)
    {
        // Ensure the user is an admin
        if (auth()->user()->role !== \App\Enums\UserRole::admin) {
            return redirect('/home')->with('status', 'You do not have access to this page.');
        }


        // Validate the request data
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products_table,product_id',
            'stock_outgoing' => 'required|integer',
        ]);

        //dd($validatedData);

        // Find the inventory item by ID
        $inventory = Inventory::findOrFail($id);

        //dd($inventory);



        // Update the inventory item
        $inventory->update([
            'product_id' => $request['product_id'],
            'stock_outgoing' => $validatedData['stock_outgoing'],
            'admin_id' => Admin::where('user_id', Auth::id())->value('admin_id'), // Update the admin who made the change
        ]);

        //dd($inventory);

        return redirect()->route('admin.inventory')->with('status', 'Inventory item outgoing stock updated successfully!');
    }

    public function destroy($id)
    {
        // Ensure the user is an admin
        if (auth()->user()->role !== \App\Enums\UserRole::admin) {
            return redirect('/home')->with('status', 'You do not have access to this page.');
        }

        // Find the inventory item by ID
        $inventory = Inventory::findOrFail($id);

        // Delete the inventory item
        $inventory->delete();

        return redirect()->route('admin.inventory')->with('status', 'Inventory item deleted successfully!');
    }

    public function dashboard() {

        // Check if user is logged in first or role will read as null throwing error
        // Ensure the user is an admin
        if (!Auth::check()) {
            return redirect()->route('sign-in')->with('status', 'Please log in to view');
        }
        if (auth()->user()->role !== \App\Enums\UserRole::admin) {
            return redirect('/home')->with('status', 'You do not have access to this page.');
        }

        $stockData = Inventory::with('product')->get();
    
        $parsedData = [];
        foreach ($stockData as $stock) {
            $parsedData[] = '["' . addslashes($stock->product['product_name']) . '", ' . $stock->stock_incoming . ', ' . $stock->stock_outgoing . ']';
        }
    
        $parsed = implode(",", $parsedData);
    
        $pending = Order::where('status', 'pending')->count();
        $shipped = Order::where('status', 'shipped')->count();
        $delivered = Order::where('status', 'delivered')->count();
        $cancelled = Order::where('status', 'cancelled')->count();
        $pieData = '["Status", "Count"], 
                    ["Pending", ' . $pending . '], 
                    ["Shipped", ' . $shipped . '], 
                    ["Delivered", ' . $delivered . '], 
                    ["Cancelled", ' . $cancelled . ']';

        $totalOrders = Order::all()->count();
        return view('admin.dashboard', ['stockChartData' => $parsed, 'pieChartData' => $pieData, 'totalOrders' => $totalOrders]);
    }

    public function search(Request $request) {
        $query = $request->input('query');
        $category = $request->input('category');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
    
        $inventory = Inventory::with('product')
            ->whereHas('product', function ($queryBuilder) use ($query, $category, $minPrice, $maxPrice) {
                if ($query) {
                    $queryBuilder->where('product_name', 'LIKE', "%$query%")
                                ->orWhere('category_name', 'LIKE', "%$query%");
                }
                if ($category) {
                    $queryBuilder->where('category_name', $category);
                }
                if ($minPrice !== null && $maxPrice !== null) {
                    $queryBuilder->whereBetween('price', [$minPrice, $maxPrice]);
                } elseif ($minPrice !== null) {
                    $queryBuilder->where('price', '>=', $minPrice);
                } elseif ($maxPrice !== null) {
                    $queryBuilder->where('price', '<=', $maxPrice);
                }
            })
            ->get();
        return view('admin.inventory', compact('inventory'));
    }
}
