
@extends('layouts.master')

@section('content')

<main class="sign-inMain">
    <section class="login-container">
            <h1>Login</h1>
            <form>
                <div class="form-text">
                    <label for="username">Username</label>
                    <input type="text" id="username" placeholder="Username" />
                </div>
                <div class="form-text">
                    <label for="password">Password</label>
                    <input type="password" id="password" placeholder="Password" />
                </div>
                <a href="#" class="forgot-details">Forgot Details?</a>
                <button type="submit" class="login-btn">Log-In</button>
            </form>
            <div class="signup-prompt">
                <p>Don’t have an account?</p>
                <a href="{{  url('/sign-up')}}" class="signup-link">Sign Up Now</a>
            </div>
        </section>
</main>

@endsection
