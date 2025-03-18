@extends('layouts.master')

@section('content')
<div class="container">
    <h2 class="page-title">Return Request Form</h2>

    <form action="{{ url('/submit-return-request') }}" method="POST">
        @csrf
        <label for="order_id">Order ID:</label>
        <input type="text" name="order_id" value="{{ $order_id }}" readonly>

        <label for="product_id">Select Product:</label>
        <select name="product_id" required>
            <option value="">-- Select a product --</option>
            @foreach ($orderDetails as $product)
                <option value="{{ $product->product_id }}">{{ $product->product_name }}</option>
            @endforeach
        </select>

        <label for="reason">Reason for Return:</label>
        <textarea name="reason" id="reason" required></textarea>

        <button type="submit" class="return-button">Submit Return Request</button>
    </form>
</div>
@endsection
