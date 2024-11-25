<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|string|max:255|min:8|confirmed',
            'password_confirmation' => 'required|string|max:255|min:8',
            'email' => 'required|string|email|max:255|unique:users_table',
            'phone_number' => 'required|string|max:15',
            'role' => 'required|in:user,admin',
        ]);

        $input = $request->only(['name', 'password', 'email', 'phone_number', 'role']);
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        return $this->sendResponse($user, 'User created successfully.');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:8'
        ]);
        // Attempt to authenticate the user
        if (!Auth::attempt($credentials)) {
            return $this->sendError('Invalid credentials.', [], 401);
        }

        // Retrieve the authenticated user
        $user = Auth::user();

        // Ensure the authenticated user is correctly retrieved
        if ($user instanceof User) {
            $token = $user->createToken('AppToken')->plainTextToken;
            return $this->sendResponse([
                'token' => $token,
                'user' => $user,
            ], 'User logged in successfully.');
        }

        return $this->sendError('User not found after authentication.', [], 401);
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
