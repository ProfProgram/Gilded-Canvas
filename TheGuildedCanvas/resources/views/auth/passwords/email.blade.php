@extends('layouts.master')

@section('content')
<main class="sign-inMain">
    <div class="login-container">
        <h1>Reset Password</h1>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="form-text">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" id="email" name="email" class="form-control" required autofocus>
            </div>

            <button type="submit" class="login-btn">Send Password Reset Link</button>
        </form>
    </div>
</main>
@endsection
