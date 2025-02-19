<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function login(Request $request)
    {
        Session::start();
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:8'
        ],[
            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 8 characters.',
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withInput()->withErrors(['email' => 'The email address does not exist.']);
        }

        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            // Regenerate the session to prevent session fixation attacks
            $request->session()->regenerate();

            // Redirect to the home page
            return redirect()->intended($this->redirectPath())->with('status', 'User logged in successfully.');
        }

        // If authentication fails, redirect back with an error message
        return back()->withInput()->withErrors(['password' => 'The password is incorrect.']);
    }
    /**
     * Where to redirect users after login.
     *
     * @return string
     */


    /**
     * Override the logout method to clear additional state.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

}
