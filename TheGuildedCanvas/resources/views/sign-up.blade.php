
@extends('layouts.master')

@section('content')

<main class="sign-upMain">
    <section class="login-container">
        <h1>Signup</h1>
        <form>
            <div class="form-text">
                <label for="username">Username</label>
                <input type="text" id="username" placeholder="Username" />
            </div>
            <div class="form-text">
                <label for="password">Password</label>
                <input type="password" id="password" placeholder="Password" />
            </div>
            <button type="submit" class="login-btn">Signup</button>
        </form>
        <div class="signup-prompt">
            <p>have an account?</p>
            <a href="{{ url('/sign-in') }}" class="signup-link">Login Now</a>
        </div>
    </section>
</main>

@endsection
