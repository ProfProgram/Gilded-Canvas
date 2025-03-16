@extends('layouts.master')

@section('content')
<div class="container">
    <h2 class="page-title">Customer Management</h2>
    
    <!-- Success Message -->
    @if(session('status'))
        <div class="alert alert-warning">
            {{ session('status') }}
        </div>
    @endif

    <p>Welcome to the Customer Management page. Only admins can access this page.</p>
</div>
@endsection
