<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function manage()
    {
        // ✅ Ensure only admins can access
        if (!Auth::check()) {
            return redirect()->route('sign-in')->with('status', 'Please log in to view your previous orders.');
        }

        return view('admin.customers'); // ✅ Renders the blank customer management page
    }
}
