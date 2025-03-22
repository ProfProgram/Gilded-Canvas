<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Inventory;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    /**
     * Constructor - Apply admin role check to all methods.
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
     * Display the inventory management page.
     */
    public function index()
    {
        $products = Product::with('inventory')->get(); // eager load inventory relationship
        return view('admin.inventory', compact('products'));
    }

    /**
     * Show the "Add Product" form.
     */
    public function create()
    {
        return view('admin.product.create');
    }

    /**
     * Store a newly created product and add it to inventory.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'height' => 'required|numeric|min:0',
            'width' => 'required|numeric|min:0',
            'description' => 'required|string',
            'category_name' => 'required|string|max:255',
        ]);

        $product = Product::create($validated);

        Inventory::create([
            'product_id' => $product->id,
            'stock_level' => 0,
            'admin_id' => Admin::where('user_id', Auth::id())->value('admin_id'),
        ]);

        return redirect()->route('admin.inventory')->with('success', 'Product added successfully!');
    }

    /**
     * Update an existing product and its inventory.
     */
    public function updateProduct(Request $request, $id)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'height' => 'required|numeric|min:0',
            'width' => 'required|numeric|min:0',
            'description' => 'required|string',
            'category_name' => 'required|string|max:255',
            'stock_level' => 'required|integer|min:0',
        ]);

        $product = Product::findOrFail($id);
        $product->update($validated);

        Inventory::updateOrCreate(
            ['product_id' => $product->id],
            [
                'stock_level' => $validated['stock_level'],
                'admin_id' => Admin::where('user_id', Auth::id())->value('admin_id'),
            ]
        );

        return redirect()->route('admin.inventory')->with('success', 'Product updated successfully.');
    }

    /**
     * Delete a product and its inventory (if any).
     */
    public function destroyProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete(); // Will also delete inventory if cascade is set

        return redirect()->route('admin.inventory')->with('success', 'Product deleted successfully.');
    }

    /**
     * (Optional) Update just inventory stock level.
     */
    public function updateStock(Request $request, $id)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'stock_level' => 'required|integer|min:0',
        ]);

        $inventory = Inventory::findOrFail($id);
        $inventory->update([
            'product_id' => $validated['product_id'],
            'stock_level' => $validated['stock_level'],
            'admin_id' => Admin::where('user_id', Auth::id())->value('admin_id'),
        ]);

        return redirect()->route('admin.inventory')->with('status', 'Stock updated successfully!');
    }

    /**
     * (Optional) Delete only inventory entry.
     */
    public function destroyInventory($id)
    {
        $inventory = Inventory::findOrFail($id);
        $inventory->delete();

        return redirect()->route('admin.inventory')->with('status', 'Inventory item deleted.');
    }
}
