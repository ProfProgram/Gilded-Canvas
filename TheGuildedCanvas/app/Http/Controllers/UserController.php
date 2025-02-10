<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
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
        Session::start();
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|string|max:255|min:8|confirmed',
            'password_confirmation' => 'required|string|max:255|min:8',
            'email' => 'required|string|email|max:255|unique:users_table',
            'phone_number' => 'required|string|max:15',
            'role' => 'user'
        ]);

        $input = $request->only(['name', 'password', 'email', 'phone_number','role']);
        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);
        /*$user = new User;
        $user->name = $request->name;
        $user->password = $request->password;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->role = $request->role;
        $user->save();*/
        Mail::to($user->email)->send(new TestMail($user->name, $user->email));

        Auth::login($user);
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
        Session::start();
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:8'
        ]);

        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            // Regenerate the session to prevent session fixation attacks
            $request->session()->regenerate();

            // Redirect to the home page
            return redirect()->route('home')->with('status', 'User logged in successfully.');
        }

        // If authentication fails, redirect back with an error message
        return back()->withErrors(['error' => 'Invalid credentials.']);
    }

    public function logout(Request $request)
    {
        Session::start();
        // Retrieve the authenticated user
        Auth::logout();

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate the CSRF token
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
