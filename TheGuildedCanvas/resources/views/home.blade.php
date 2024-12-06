
@extends('layouts.master')

@section('content')

<!-- Hero Section -->
<section class="hero" id="home">
    <h1>Welcome to The Gilded Canvas</h1>
    <p>Where art meets elegance. Discover unique and timeless pieces crafted for the discerning collector.</p>
    <a href="#products" class="btn">Shop Now</a>
</section>

<!-- Product Slider Section -->
<section class="products" id="products">
    <h2>Featured Products</h2>
    <div class="slider">
        <div class="slider-track">
            <!-- Product 1: Gilded Frame Art -->
            <a href="product1.html" class="product-slide">
                <img src="Images/gilded-frame-art.png" alt="Gilded Frame Art">
                <p>Gilded Frame Art</p>
                <p class="price">£199.99</p>
                <button class="btn">Add to Cart</button>
            </a>
            <!-- Product 2: Golden Vase -->
            <a href="product2.html" class="product-slide">
                <img src="Images/golden-vase.png" alt="Golden Vase">
                <p>Golden Vase</p>
                <p class="price">£149.99</p>
                <button class="btn">Add to Cart</button>
            </a>
            <!-- Product 3: Luxury Wall Clock -->
            <a href="product3.html" class="product-slide">
                <img src="Images/luxury-wall-clock.png" alt="Luxury Wall Clock">
                <p>Luxury Wall Clock</p>
                <p class="price">£249.99</p>
                <button class="btn">Add to Cart</button>
            </a>
        </div>
        <button class="slider-btn prev-btn">❮</button>
        <button class="slider-btn next-btn">❯</button>
    </div>
</section>

@endsection

