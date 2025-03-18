@extends('layouts.master')

@section('content')
<div class="container">
    <h2 class="page-title">Return Order</h2>

    <div class="return-form">
        <p><strong>Order ID:</strong> {{ $order->id }}</p>
        <p><strong>Product:</strong> {{ $order->product_names }}</p>
        <p><strong>Quantity:</strong> {{ $order->product_quantities }}</p>
        <p><strong>Total Price:</strong> £{{ number_format($order->total_price, 2) }}</p>

        <form action="{{ route('order.processReturn', ['order_id' => $order->id]) }}" method="POST">
            @csrf
            <label for="reason">Reason for Return:</label>
            <textarea name="reason" id="reason" required></textarea>

            <button type="submit" class="return-button">Submit Return Request</button>
        </form>
    </div>
</div>
@endsection
