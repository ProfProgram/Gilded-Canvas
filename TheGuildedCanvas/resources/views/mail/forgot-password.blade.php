@extends('layouts.master')

@section('content')
    <div class="container">
        <h2>Forgot Password</h2>
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        <form action="{{ route('password.email') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email Address: </label>
                <input type="email" name="email" id="email" class="form-control" required>
                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <button type="submit" class="btn btn-primary">Send Password Reset Link</button>
        </form>
    </div>
@endsection
