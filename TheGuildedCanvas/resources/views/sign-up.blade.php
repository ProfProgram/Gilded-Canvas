
@extends('layouts.master')

@section('content')

<main class="sign-upMain">
    <section class="login-container">
        <h1>Signup</h1>
        <form>
            @csrf
            <div class="form-text">
                <label for="username">Username</label>
                <input type="text" name="name" id="username" placeholder="Username" required/>
            </div>
            <div class="form-text">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Password" required/>
            </div>
            <div class="form-text">
                <label for="password-confirm">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password-confirm" placeholder="Password-confirm" required>
            </div>
            <div class="form-text">
                <label for="email">Email</label>
                <input type="text" name="email" id="email" placeholder="name@domain.com" required>
            </div>
            <div class="form-text">
                <label for="phone_number">Phone Number</label>
                <input type="number" name="phone_number" id="phone_number" placeholder="123456789012345" min="0" max="123456789012345" required>
            </div>
            <div class="form-text">
                <label for="role">Role</label>
                <select name="role" required>
                    <option value="User">User</option>
                    <option value="User">Admin</option>
                </select>
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
