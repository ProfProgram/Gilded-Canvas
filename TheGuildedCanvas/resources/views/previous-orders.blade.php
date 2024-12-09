@extends('layouts.master')

@section('content')

<main class="orders-container">
    <h1 class="orders-title">Previous Orders</h1>
    <div class="orders-layout">
        <!-- Example Order -->
        <div class="order-item">
            <div class="product-image">
                <img src="Images/ProductOne.jpg" alt="Gold Leaf Canvas">
            </div>
            <div class="product-details">
                <h3>Gold Leaf Canvas</h3>
                <p>Ordered on: 20th November 2024</p>
                <p>Total: £50.00</p>
            </div>
            <button class="reorder-button">Reorder</button>
        </div>
        <hr class="divider">
        <div class="order-item">
            <div class="product-image">
                <img src="Images/ProductTwo.jpg" alt="Luxury Canvas">
            </div>
            <div class="product-details">
                <h3>Luxury Canvas</h3>
                <p>Ordered on: 10th November 2024</p>
                <p>Total: £75.00</p>
            </div>
            <button class="reorder-button">Reorder</button>
        </div>
    </div>
</main>

@endsection