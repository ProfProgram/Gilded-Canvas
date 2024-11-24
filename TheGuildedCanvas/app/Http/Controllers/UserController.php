<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return $this->sendResponse($users, 'Users retrieved successfully.');
    }

    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            return $this->sendError('User not found.');
        }
        return $this->sendResponse($user, 'User retrieved successfully.');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'Name' => 'required|string|max:255',
            'Password' => 'required|string|max:255|min:8|confirmed',
            'Password_confirmation' => 'required|string|max:255|min:8',
            'Email' => 'required|string|email|max:255|unique:users_table',
            'Phone_number' => 'required|string|max:15',
            'Role' => 'required|in:User,Admin',
        ]);

        $input = $request->only(['Name', 'Password', 'Email', 'Phone_number', 'Role']);
        $input['Password'] = bcrypt($input['Password']);
        $user = User::create($input);

        return $this->sendResponse($user, 'User created successfully.');
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return $this->sendError('User not found.');
        }

        $user->update($request->all());

        return $this->sendResponse($user, 'User updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted'], 200);
    }
}
