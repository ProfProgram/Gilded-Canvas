
@extends('layouts.master')

@section('content')

<div class="container">
    <div class="product-header">
        <h1>Product Page</h1>
    </div>

    <!-- Product 1 -->
    <div class="product">
        <div class="product-image">
            <img src="{{ asset('images/openart-image_1.jpg') }}" alt="Product 1 Image">
        </div>
        <div class="product-details">
            <h2>Product Name 1</h2>
            <p>This is the description for Product 1. It highlights the key features and benefits of the product.</p>
            <p class="product-price">$99.99</p>
            <a href="#" class="buy-button">Buy Now</a>
        </div>
    </div>

    <!-- Product 2 -->
    <div class="product">
        <div class="product-image">
            <img src="{{ asset('images/openart-image_2.jpg') }}" alt="Product 2 Image">
        </div>
        <div class="product-details">
            <h2>Product Name 2</h2>
            <p>This is the description for Product 2. It provides details about its unique qualities and uses.</p>
            <p class="product-price">$149.99</p>
            <a href="#" class="buy-button">Buy Now</a>
        </div>
    </div>

    <!-- Product 3 -->
    <div class="product">
        <div class="product-image">
            <img src="{{ asset('images/openart-image_3.jpg') }}" alt="Product 3 Image">
        </div>
        <div class="product-details">
            <h2>Product Name 3</h2>
            <p>This is the description for Product 3. It explains its advantages and how it stands out from the competition.</p>
            <p class="product-price">$199.99</p>
            <a href="#" class="buy-button">Buy Now</a>
        </div>
    </div>
</div>

@endsection
