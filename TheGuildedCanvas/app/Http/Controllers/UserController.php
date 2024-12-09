<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Mail\ResetPassword;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use illuminate\Support\Facades\Password;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    use SendsPasswordResetEmails;
    public function updatePassword(Request $request): JsonResponse
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users_table,email',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        // Update the password
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['message' => 'Password has been reset successfully!']);
    }

    public function register(Request $request)
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

        //return $this->sendResponse($user, 'User created successfully. Please check your email to verify your account.');
        return redirect()->route('home')->with('status', 'User created successfully. Please check your email to verify your account.');
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

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $user = User::where('email', $request->email)->first();

        // Generate a token (you may want to store this in a password_resets table for verification)
        $token = bin2hex(random_bytes(16));


        Mail::to($user->email)->send(new ResetPassword($user, $token));

        return response()->json(['message' => 'We have emailed your password reset link!'], 200);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
        ]);

        $user = User::where('email', $request->email)->first();

        $user->password = Hash::make($request->password);
        $user->save();

        // Optionally, delete the token after resetting the password
        // $reset->delete();

        return response()->json(['message' => 'Password has been reset successfully!']);
    }


    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:8'
        ]);
        // Attempt to authenticate the user
        if (!Auth::attempt($credentials)) {
            return back()->withErrors(['error' => 'Invalid credentials.']);
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

            //return redirect()->route('home')->with('status', 'User logged in successfully.');
            return redirect()->route('home')->with('status', 'User logged in successfully.');
        }

        return back()->withErrors(['error' => 'User not found after authentication.']);
    }

    public function logout(Request $request)
    {
        // Retrieve the authenticated user
        $user = $request->user();

        if ($user) {
            // Revoke the token that was used in the current request
            $request->user()->currentAccessToken()->delete();

            return redirect('/home')->with('status', 'User logged out successfully.');
        }
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/home')->with('status', 'User logged out successfully.');
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