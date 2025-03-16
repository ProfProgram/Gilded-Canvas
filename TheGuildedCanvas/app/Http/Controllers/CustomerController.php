<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CustomerController extends Controller
{
    public function manage(Request $request) 
    {
        if (!Auth::check()) {
                return redirect()->route('sign-in')->with('status', 'Please log in to view your previous orders.');
        }
    
        
        $query = User::where('role', 'user');
    
        if ($request->has('search') && !empty($request->search)) {
            $query->where(function ($q) use ($request) {
                $q->where('user_id', 'LIKE', "%{$request->search}%")
                  ->orWhere('name', 'LIKE', "%{$request->search}%");
            });
        }
    
        $customers = $query->select('user_id', 'name', 'email', 'phone_number', 'created_at')
                            ->orderBy('created_at', 'desc')
                            ->get();
    
        return view('admin.customers', compact('customers'));
    }
}
