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
    // Ensure the user is an admin
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

        return view('admin.dashboard', ['stockChartData' => $parsed, 'pieChartData' => $pieData]);
    }
}
