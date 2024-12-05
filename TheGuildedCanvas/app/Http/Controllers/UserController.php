<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;

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
        Mail::to($user->email)->send(new TestMail($user->name, $user->email));

        return $this->sendResponse($user, 'User created successfully. Please check your email to verify your account.');
    }
    public function verifyEmail(Request $request)
    {
        $email = $request->query('email');

        $user = User::where('email', $email)->first();

        if ($user) {
            $user->email_verified_at = now();
            $user->save();

            return view('auth.email-verified')->with('message', 'Email verified successfully!');
        }

        return view('auth.email-verified')->with('message', 'No such email found or already verified.');
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
            $tokenName = 'UserAccessToken';
            $tokenAbilities = ['user'];

            if ($user->role === UserRole::admin) {
                $tokenName = 'AdminAccessToken';
                $tokenAbilities = ['admin'];
            }

            // Create the token with abilities
            $token = $user->createToken($tokenName, $tokenAbilities)->plainTextToken;

            return $this->sendResponse([
                'token' => $token,
                'user' => $user,
            ], 'User logged in successfully.');
        }

        return $this->sendError('User not found after authentication.', [], 401);
    }

    public function logout(Request $request)
    {
        // Retrieve the authenticated user
        $user = $request->user();

        if ($user) {
            // Revoke the token that was used in the current request
            $request->user()->currentAccessToken()->delete();

            return $this->sendResponse([], 'User logged out successfully.');
        }

        return $this->sendError('User not found.', [], 404);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return $this->sendError('User not found.');
        }
        $validatedData = $request->validate([
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
        ]);

        if ($request->has('password')) {
            $validatedData['password'] = bcrypt($request->password);
        }
        $user->update($validatedData);
        return $this->sendResponse($user, 'User password updated successfully.');
    }

    public function destroy($id)
    {
        // Find the user by ID
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Revoke all tokens associated with the user
        $user->tokens()->delete();

        // Proceed to delete the user
        $user->delete();

        return response()->json(['message' => 'User deleted'], 200);
    }
}
