<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ResetPassword;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;

class ForgotPasswordController extends Controller
{
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        // Generate a unique token
        $token = Str::random(60);

        // Store email and token in the database
        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => Carbon::now()]
        );

        // Send the custom reset email
        Mail::to($request->email)->send(new ResetPassword($request->email, $token));

        return back()->with('status', 'A password reset link has been sent to your email.');
    }

    public function sendResetLinkForLoggedInUser(Request $request)
    {
        // Get the authenticated user
        $user = auth()->user();
        if (!$user) {
            return back()->withErrors(['error' => 'No authenticated user found.']);
        }

        // Use the email from the request or fall back to the authenticated user's email
        $email = $request->email ?? $user->email;

        // Generate a unique token
        $token = Str::random(60);

        // Store the token in the password_resets table
        DB::table('password_resets')->updateOrInsert(
            ['email' => $email],
            ['token' => $token, 'created_at' => Carbon::now()]
        );

        // Send the custom reset email
        Mail::to($email)->send(new ResetPassword($email, $token));

        // Return success response
        return back()->with('status', 'A reset password link has been sent to your email.');
    }

    public function showForgotForm()
    {
        return view('auth.passwords.email');
    }
}
