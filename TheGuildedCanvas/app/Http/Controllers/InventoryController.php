<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Inventory;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role !== \App\Enums\UserRole::admin) {
                return redirect('/home')->with('error', 'You do not have access to this page.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $products = Product::with('inventory')->get();
        return view('admin.inventory', compact('products'));
    }

    public function create()
    {
        return view('admin.product.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name'   => 'required|string|max:255',
            'price'          => 'required|numeric|min:0',
            'height'         => 'required|numeric|min:0',
            'width'          => 'required|numeric|min:0',
            'description'    => 'required|string',
            'category_name'  => 'required|string|max:255',
            'stock_level'    => 'nullable|integer|min:0',
        ]);

        try {
            $product = Product::create([
                'product_name'   => $validated['product_name'],
                'price'          => $validated['price'],
                'height'         => $validated['height'],
                'width'          => $validated['width'],
                'description'    => $validated['description'],
                'category_name'  => $validated['category_name'],
            ]);

            Inventory::create([
                'product_id'   => $product->product_id,
                'stock_level'  => $validated['stock_level'] ?? 0,
                'admin_id'     => Admin::where('user_id', Auth::id())->value('admin_id'),
            ]);

            return redirect()->route('admin.inventory')->with('success', 'Product added successfully!');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return redirect()->back()
                    ->withErrors(['product_name' => 'A product with this name already exists.'])
                    ->withInput();
            }
            throw $e;
        }
    }

    public function updateProduct(Request $request, $id)
    {
        $validated = $request->validate([
            'product_name'   => 'required|string|max:255',
            'price'          => 'required|numeric|min:0',
            'height'         => 'required|numeric|min:0',
            'width'          => 'required|numeric|min:0',
            'description'    => 'required|string',
            'category_name'  => 'required|string|max:255',
            'stock_level'    => 'required|integer|min:0',
        ]);

        $product = Product::findOrFail($id);
        $product->update($validated);

        Inventory::updateOrCreate(
            ['product_id' => $product->product_id],
            [
                'stock_level' => $validated['stock_level'],
                'admin_id'    => Admin::where('user_id', Auth::id())->value('admin_id'),
            ]
        );

        return redirect()->route('admin.inventory')->with('success', 'Product updated successfully!');
    }

    public function destroyProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.inventory')->with('success', 'Product deleted successfully!');
    }

    public function updateStock(Request $request, $id)
    {
        $validated = $request->validate([
            'stock_level' => 'required|integer|min:0',
        ]);

        $inventory = Inventory::findOrFail($id);
        $inventory->update([
            'stock_level' => $validated['stock_level'],
            'admin_id'    => Admin::where('user_id', Auth::id())->value('admin_id'),
        ]);

        return redirect()->route('admin.inventory')->with('status', 'Stock updated successfully!');
    }

    public function destroyInventory($id)
    {
        $inventory = Inventory::findOrFail($id);
        $inventory->delete();

        return redirect()->route('admin.inventory')->with('status', 'Inventory item deleted.');
    }
}
