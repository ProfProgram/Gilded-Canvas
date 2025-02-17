
@extends('layouts.master')

@section('content')
@if (session('status'))
    <div class="alert">
        <p class="message">{{ session('status') }}</p>
        <form method="POST" action="{{ url('/close-alert') }}" style="display: inline;">
            @csrf
            <button type="submit" class="close-btn">✖</button>
        </form>
    </div>
@endif
<main>
    <section class="login-container">
        <h1>Login</h1>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-text">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Email" required />
            </div>
            <div class="form-text">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Password" required />
            </div>
            <a href="{{ route('password.request') }}" class="forgot-details">Forgot Details?</a>
            <button type="submit" class="login-btn">Log-In</button>
        </form>
        <div class="signup-prompt">
            <p>Don’t have an account?</p>
            <a href="{{ url('/sign-up') }}" class="signup-link">Sign Up Now</a>
        </div>
    </section>
</main>

@endsection
