<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Inventory;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use Illuminate\Http\Request;

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
            'stock_incoming'    => 'nullable|integer|min:0',
            'stock_outgoing'    => 'nullable|integer|min:0',
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
                'stock_incoming'  => $validated['stock_incoming'] ?? 0,
                'stock_outgoing'  => $validated['stock_outgoing'] ?? 0,
                'admin_id'     => Admin::where('user_id', Auth::id())->value('admin_id'),
            ]);

            return redirect()->route('admin.inventory')->with('status', 'Product added successfully!');
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
            'stock_incoming'    => 'required|integer|min:0',
            'stock_outgoing'    => 'required|integer|min:0',
        ]);

        $product = Product::findOrFail($id);
        $product->update($validated);

        Inventory::updateOrCreate(
            ['product_id' => $product->product_id],
            [
                'stock_level' => $validated['stock_level'],
                'stock_incoming' => $validated['stock_incoming'],
                'stock_outgoing' => $validated['stock_outgoing'],
                'admin_id'    => Admin::where('user_id', Auth::id())->value('admin_id'),
            ]
        );

        return redirect()->route('admin.inventory')->with('status', 'Product updated successfully!');
    }

    public function destroyProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.inventory')->with('status', 'Product deleted successfully!');
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
