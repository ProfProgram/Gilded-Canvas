@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/loginandsignup.css') }}">
@section('content')
    <main>
        <section class="login-container">
            <h1>Reset Password</h1>
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-text">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="Email">
                </div>

                <div class="form-text">
                    <label for="password">New Password</label>
                    <input type="password" name="password" id="password" required placeholder="New Password">
                </div>

                <div class="form-text">
                    <label for="password-confirm">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password-confirm" required placeholder="Confirm Password">
                </div>

                <button type="submit" class="login-btn">Reset Password</button>
            </form>
        </section>
    </main>
@endsection
