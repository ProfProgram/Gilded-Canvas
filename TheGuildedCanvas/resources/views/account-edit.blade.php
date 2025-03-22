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
    <main class="sign-inMain">
    @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif
    <div class= "login-container">
        <h1>Account Details</h1>
        <form method="POST" action="{{ route('account.update') }}" >
            @csrf
            @method('PUT')

            <div class="form-text">
                <label>Email</label>
                <input type="email" name="email" value="{{ Auth::user()->email }}" required>
            </div>

            <div class="form-text">
                <label>Phone Number</label>
                <input type="text" name="phone_number" value="{{ Auth::user()->phone_number }}" required>
            </div>

            <div class="form-text">
                <label>Current Password (required to change password)</label>
                <input type="password" name="current_password">
            </div>

            <div class="form-text">
                <label>New Password</label>
                <input type="password" name="password">
            </div>

            <div class="form-text">
                <label>Confirm New Password</label>
                <input type="password" name="password_confirmation">
            </div>
            <button type="submit" >Save Changes</button>
            <button type="button" onclick="window.location.href='{{ route('account.edit') }}'">Cancel</button>
            <span style="margin-right: 10px !important;"></span>
        </form>
        <form action="{{ route('password.authenticated-reset') }}" method="POST">
            @csrf
            <input type="hidden" name="email" value="{{ Auth::user()->email }}">
            <button type="submit">Send Password Reset Link</button>
        </form>
    </div>
    </main>

    <script>
        function toggleEdit() {
            document.getElementById('detailsView').style.display =
                document.getElementById('detailsView').style.display === 'none' ? 'block' : 'none';
            document.getElementById('editForm').style.display =
                document.getElementById('editForm').style.display === 'none' ? 'block' : 'none';
        }
    </script>
@endsection
