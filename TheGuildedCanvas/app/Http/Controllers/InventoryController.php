?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Inventory;
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

        return view('admin.inventory', compact('inventory'));
    }

    public function update(Request $request, $id)
    {
        // Ensure the user is an admin
        if (auth()->user()->role !== \App\Enums\UserRole::admin) {
            return redirect('/home')->with('status', 'You do not have access to this page.');
        }

        // Validate the request data
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,product_id',
            'stock_level' => 'required|integer',
        ]);

        // Find the inventory item by ID
        $inventory = Inventory::findOrFail($id);

        // Update the inventory item
        $inventory->update([
            'product_id' => $request->product_id,
            'stock_level' => $validatedData['stock_level'],
            'admin_id' => Admin::where('user_id', Auth::id())->value('admin_id'), // Update the admin who made the change
        ]);

        return redirect()->route('admin.inventory')->with('status', 'Inventory item updated successfully!');
    }

    public function destroy($id)
    {
        // Ensure the user is an admin
        if (auth()->user()->role !== \App\Enums\UserRole::admin) {
            return redirect('/home')->with('status', 'You do not have access to this page.');
        }

        // Find and delete the inventory item
        $inventory = Inventory::findOrFail($id);
        $inventory->delete();

        return redirect()->route('admin.inventory')->with('status', 'Inventory item deleted successfully!');
    }

    /**
     * Show the form for adding a new product.
     */
    public function create()
    {
        // Ensure the user is an admin
        if (auth()->user()->role !== \App\Enums\UserRole::admin) {
            return redirect('/home')->with('status', 'You do not have access to this page.');
        }

        return view('admin.product.create'); // Ensure this view exists
    }

    /**
     * Store a newly created product.
     */
    public function store(Request $request)
    {
        // Ensure the user is an admin
        if (auth()->user()->role !== \App\Enums\UserRole::admin) {
            return redirect('/home')->with('status', 'You do not have access to this page.');
        }

        // Validate form input
        $validatedData = $request->validate([
            'product_name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'height' => 'required|numeric',
            'width' => 'required|numeric',
            'description' => 'required|string',
            'category_name' => 'required|string|max:255',
        ]);

        // Create and save the product
        Product::create([
            'product_name' => $validatedData['product_name'],
            'price' => $validatedData['price'],
            'height' => $validatedData['height'],
            'width' => $validatedData['width'],
            'description' => $validatedData['description'],
            'category_name' => $validatedData['category_name'],
        ]);

        return redirect()->route('admin.inventory')->with('success', 'Product added successfully!');
    }
}
