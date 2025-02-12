<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Manager;
use Illuminate\Http\Request;
use App\Models\User;

class UserManagementController extends Controller
{

    public function index()
    {
        if (auth()->user()->role !== \App\Enums\UserRole::manager) {
            return redirect('/home')->with('error', 'You do not have access to this page.');
        }
        // Fetch all users
        $users = User::all();

        return view('manager.users', ['users' => $users]);
    }

    public function updateRole(Request $request, $id)
    {
        if (auth()->user()->role !== \App\Enums\UserRole::manager) {
            return redirect('/home')->with('error', 'You do not have access to this page.');
        }
        // Validate the request data
        $validatedData = $request->validate([
            'role' => 'required|in:admin,manager,user',
        ]);
        if ($validatedData['role'] === 'admin') {
            $admin = Admin::create(['user_id' => $id]);
        }
        if ($validatedData['role'] === 'manager') {
            $manager = Manager::create(['user_id' => $id]);
        }
        if ($validatedData['role'] === 'user') {
            $admin = Admin::findOrFail(['user_id'=> $id]);
            $manager = Manager::findOrFail(['user_id'=> $id]);
            $manager->delete();
            $admin->delete();
        }


        // Find the user
        $user = User::findOrFail($id);

        // Update the user's role
        $user->update(['role' => $validatedData['role']]);

        return redirect()->route('manager.users')->with('status', 'User role updated successfully!');
    }

    public function destroy($id)
    {
        // Ensure the user is a manager
        if (auth()->user()->role !== \App\Enums\UserRole::manager) {
            return redirect('/home')->with('error', 'You do not have access to this page.');
        }

        // Find the user
        $user = User::findOrFail($id);

        // Delete the user
        $user->delete();

        return redirect()->route('manager.users')->with('status', 'User deleted successfully!');
    }
}
