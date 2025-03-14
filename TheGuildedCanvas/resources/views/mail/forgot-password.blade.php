@extends('layouts.master')

@section('content')
    <div class="login-container">
        <h1>Forgot Password</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        <form action="{{ route('password.email') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email Address: </label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <button type="submit" class="login-btn">Send Password Reset Link</button>
        </form>
    </div>
@endsection
