<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;

class InventoryController extends Controller
{
    /**
     * Constructor - Apply admin middleware to all methods.
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role !== \App\Enums\UserRole::admin) {
                return redirect('/home')->with('status', 'You do not have access to this page.');
            }
            return $next($request);
        });
    }

    /**
     * Display the inventory page.
     */
    public function index()
    {
        // Fetch all inventory items with their associated products
        $inventory = Inventory::with('product')->get();

        return view('admin.inventory', compact('inventory'));
    }

    /**
     * Update an existing inventory item.
     */
    public function update(Request $request, $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'stock_level' => 'required|integer|min:0',
        ]);

        // Find the inventory item
        $inventory = Inventory::findOrFail($id);

        // Update inventory details
        $inventory->update([
            'product_id' => $validatedData['product_id'],
            'stock_level' => $validatedData['stock_level'],
            'admin_id' => Admin::where('user_id', Auth::id())->value('admin_id'),
        ]);

        return redirect()->route('admin.inventory')->with('status', 'Inventory updated successfully!');
    }

    /**
     * Delete an inventory item.
     */
    public function destroy($id)
    {
        // Find the inventory item
        $inventory = Inventory::findOrFail($id);
        $inventory->delete();

        return redirect()->route('admin.inventory')->with('status', 'Inventory item deleted successfully!');
    }

    /**
     * Show the "Add Product" form.
     */
    public function create()
    {
        return view('admin.product.create'); // Ensure this view exists
    }

    /**
     * Store a newly created product.
     */
    public function store(Request $request)
    {
        // Validate form input
        $validatedData = $request->validate([
            'product_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'height' => 'required|numeric|min:0',
            'width' => 'required|numeric|min:0',
            'description' => 'required|string',
            'category_name' => 'required|string|max:255',
        ]);

        // Create and save the product
        $product = Product::create([
            'product_name' => $validatedData['product_name'],
            'price' => $validatedData['price'],
            'height' => $validatedData['height'],
            'width' => $validatedData['width'],
            'description' => $validatedData['description'],
            'category_name' => $validatedData['category_name'],
        ]);

        // Add the new product to the inventory with an initial stock level
        Inventory::create([
            'product_id' => $product->id,  // Link inventory to the new product
            'stock_level' => 0, // Default stock level (can be updated later)
            'admin_id' => Admin::where('user_id', Auth::id())->value('admin_id'),
        ]);

        return redirect()->route('admin.inventory')->with('success', 'Product added successfully!');
    }

    


}
