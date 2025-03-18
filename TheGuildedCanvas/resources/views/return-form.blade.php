@extends('layouts.master')

@section('content')
<div class="container">
    <h2 class="page-title">Return Request Form</h2>

    <form action="{{ url('/submit-return-request') }}" method="POST">
        @csrf
        <label for="order_id">Order ID:</label>
        <input type="text" name="order_id" required>

        <label for="product_name">Product Name:</label>
        <input type="text" name="product_name" required>

        <label for="reason">Reason for Return:</label>
        <textarea name="reason" id="reason" required></textarea>

        <button type="submit" class="return-button">Submit Return Request</button>
    </form>
</div>
@endsection

