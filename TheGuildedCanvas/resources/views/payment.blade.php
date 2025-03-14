
@extends('layouts.master')

@section('content')

<!-- outer div allows you to separate the left and right content using css -->
@php
$totalPrice = 0;
@endphp
@foreach ($cartInfo as $item)
@php
    $totalPrice += $item->quantity * $item->product->price;
@endphp
@endforeach
@if (session('status'))
<div class="alert">
    <p class="message">{{ session('status') }}</p>
    <form method="POST" action="{{ url('/close-alert') }}" style="display: inline;">
        @csrf
        <button type="submit" class="close-btn">✖</button>
    </form>
</div>
@endif
<div id="payment-wrapper">
    <div id="payment-details">
    <h2>Payment Page</h2>
    <form id="shipForm" method="POST" action="{{ url('/payment') }}">
        @csrf
        <input type="hidden" name="totalPrice" value="{{ $totalPrice }}">
        <label for="cardHolder" id="cardHolder-lbl">Card Holder</label>
        <input type="text" name="cardHolder" id="cardHolder"  placeholder="John Snow" required><br>
        <label for="cardNum" id="cardNum-lbl">Card Number</label>
        <input type="number" name="cardNum" id="cardNum" min="0" max="999999999999999" placeholder="123456789012345" required>
        <div id="ship-lastLine">
            <label for="EdMonth" id="Ed-lbl">Expiration date</label>
            <input id="EdMonth" placeholder="Month" required>
            <input id="EdYear" placeholder="Year" required>
            <label for="CVC" id="CVC-lbl">CVC</label>
            <input type="number" id="CVC" placeholder="123" required>
        </div>
        <div>
            <button type="submit" class="purchase-btn">Purchase</button>
        </div>
    </form>
    </div>
    <div class="summary">
        <h3>Summary</h3>
        <div class="summary-box">
            <table>
                <!-- Table columns -->
                <tr>
                    <th>Product ID</th>
                    <th>Product Image</th>
                    <th>Quantity</th>
                    <th>Price Per</th>
                </tr>
                @foreach ($cartInfo as $item)
                <tr>
                    <td>{{$item->product_id}}</td>
                    <td>
                        <img src="{{ asset('images/products/img-'. $item->product_id .'.png') }}" alt="Product" width="50px" height="50px">
                    </td>
                    <td>{{$item->quantity}}</td>
                    <td>{{$item->product->price}}</td>
                </tr>
                @endforeach
            </table>

        </div>
        <div class="total-section">
            <h2>Total</h2>
            <div id="total-price">
                <!-- total price -->
                <h2>{{$total_price}}</h2>
            </div>
        </div>
    </div>
</div>

@endsection
