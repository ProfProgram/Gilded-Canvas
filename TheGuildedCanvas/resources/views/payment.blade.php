
@extends('layouts.master')

@section('content')

<!-- outer div allows you to separate the left and right content using css -->
@php

$totalPrice = 0;

@endphp
<div id="prodContent">
    <div id="leftSide">
    <h1>Payment Page</h1>
    <form id="shipForm" method="POST" action="{{ url('/payment') }}">
        @csrf
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
            <button type="submit" class="btn-Purchase">Purchase</button>
        </div>
    </form>
    </div>
    <div class="rightSide">
        <h1>Summary</h1>
        <div class="prodList">
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
                        <img src="{{ asset('images/openart-image_'. $item->product_id .'.jpg') }}" alt="Product" width="50px" height="50px">
                    </td>
                    <td>{{$item->quantity}}</td>
                    <td>{{$item->product->price}}</td>
                </tr>
                @php
                    $totalPrice += $item->quantity * $item->product->price;
                @endphp
                @endforeach
            </table>

        </div>
        <div class="totalContainer">
            <h2>Total</h2>
            <div id="totalNumContainer">
                <!-- total price -->
                <h2>{{$totalPrice}}</h2>
            </div>
        </div>
    </div>
</div>

@endsection
