<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CustomerController extends Controller
{
    public function manage()
    {
        // Ensure only admins can access
       if (!Auth::check()) {
            return redirect()->route('sign-in')->with('status', 'Please log in to view your previous orders.');
        }

        // Retrieve customers from the database
         $customers = User::where('role', 'user')
                     ->select('user_id', 'name', 'email', 'phone_number', 'created_at') 
                     ->orderBy('created_at', 'desc')
                     ->get();

    return view('admin.customers', compact('customers'));
}
}
