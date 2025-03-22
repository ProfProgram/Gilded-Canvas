<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class AccountController extends Controller
{
    public function edit()
    {
        return view('account');
    }
    public function openEditPage()
    {
        return view('account-edit');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'email' => 'required|email|unique:users_table,email,' . $user->user_id . ',user_id',
            'phone_number' => 'required|string|max:15',
            'password' => 'nullable|string|confirmed|min:8',
        ]);

        $user->email = $request->email;
        $user->phone_number = $request->phone_number;

        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Your current password is incorrect.']);
            }
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect('/account')->with('status', 'Account updated successfully.');
    }

}

