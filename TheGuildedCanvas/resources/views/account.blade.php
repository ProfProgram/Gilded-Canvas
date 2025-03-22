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
    <main class="about-us-page">
        <section class="introduction">
        @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif
            <form method="GET" action="{{ route('account.editPage') }}">
            <h1 >Account Details</h1>
        <div class= "introduction" id="detailsView">
            <p class="introduction"><strong>Name:</strong> {{ Auth::user()->name }}</p>
            <p class="introduction"><strong>Email:</strong> {{ Auth::user()->email }}</p>
            <p class="introduction"><strong>Phone Number:</strong> {{ Auth::user()->phone_number }}</p>
            <button type="submit">Edit Details</button>
            </form>
        </div>
        </section>
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
