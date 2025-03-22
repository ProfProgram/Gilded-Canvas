<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the customers.
     */
    public function manage(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('sign-in')->with('status', 'Please log in to view.');
        }
        if (auth()->user()->role !== \App\Enums\UserRole::admin) {
            return redirect('/home')->with('status', 'You do not have access to this page.');
        }
       
        $query = DB::table('users_table')
            ->where('role', 'user')
            ->select('user_id', 'name', 'email', 'phone_number', 'created_at'); 
        
        if ($request->has('search') && !empty($request->search)) {
            $query->where(function ($q) use ($request) {
                $q->where('user_id', 'LIKE', "%{$request->search}%")
                  ->orWhere('name', 'LIKE', "%{$request->search}%");
            });
        }

        $customers = $query->orderBy('created_at', 'desc')->get();

        return view('admin.customers', compact('customers'));
    }

    /**
     * Store a newly created customer.
     */
    public function store(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users_table,email', 
            'password' => 'required|min:6',
            'phone_number' => 'nullable|string|max:15',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.customers')->withErrors($validator)->withInput();
        }

      
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'role' => 'user',
        ]);

        return redirect()->route('admin.customers')->with('status', 'Customer added successfully.');
    }

    /**
     * Update the specified customer.
     */
    public function update(Request $request, $id)
    {
        // Find the customer
        $customer = User::findOrFail($id);
    
       $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users_table,email,' . $customer->user_id . ',user_id',
        'phone_number' => 'nullable|string|max:15',
    ]);
    
        if ($validator->fails()) {
            return redirect()->route('admin.customers')->withErrors($validator)->withInput();
        }
    
        // Update customer details
        $customer->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
        ]);
    
        return redirect()->route('admin.customers')->with('status', 'Customer details updated successfully.');
    }
    /**
     * Remove the specified customer.
     */
    public function destroy($id)
{
    // Find the customer by user_id
    $customer = User::where('user_id', $id)->firstOrFail();

    // Delete the customer
    $customer->delete();

    // Redirect back with success message
    return redirect()->route('admin.customers')->with('status', 'Customer deleted successfully.');
}
}
