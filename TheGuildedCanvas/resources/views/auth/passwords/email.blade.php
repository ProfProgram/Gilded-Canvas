@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/loginandsignup.css') }}">
@section('content')
    <main>
        <section class="login-container">
            <h1>Forgot Password</h1>
            <form method="POST" action="{{ route('password.email') }}"> <!-- Assuming this route handles sending the password reset email -->
                @csrf
                <div class="form-text">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="Enter your email" required />
                </div>
                <button type="submit" class="login-btn">Send Password Reset Link</button>
            </form>
            <div class="signup-prompt">
                <p>Remember your password?</p>
                <a href="{{ route('login') }}" class="signup-link">Log In</a>
            </div>
        </section>
    </main>
@endsection
