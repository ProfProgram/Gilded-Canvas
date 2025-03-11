<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ResetPassword;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users_table,email']);

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

    public function showForgotForm()
    {
        return view('auth.passwords.email');
    }
}

