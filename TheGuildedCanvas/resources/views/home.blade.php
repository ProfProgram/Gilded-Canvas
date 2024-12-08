
@extends('layouts.master')

@section('content')
@php
$categoryUnordered = [];
@endphp
@foreach ($productInfo as $info)
@php
$categoryUnordered[] = $info->category_name;
@endphp
@endforeach
@php
$categories = array_unique($categoryUnordered);
@endphp
<!-- Hero Section -->
<section class="hero" id="home">
    <h1>Welcome to The Gilded Canvas</h1>
    <p>Where art meets elegance. Discover unique and timeless pieces crafted for the discerning collector.</p>
    <a href="{{url('/products')}}" class="btn">Shop Now</a>
</section>

<!-- Product Slider Section -->
<section class="products" id="products-sliders">
    <h2>Featured Products</h2>
    <div class="slider">
        <div class="slider-track">
            <!-- Product 1: Gilded Frame Art -->
            <a href="product1.html" class="product-slide">
                <img src="Images/gilded-frame-art.png" alt="Gilded Frame Art">
                <p>Gilded Frame Art</p>
                <p class="price">£199</p>
                <button class="btn">Add to Cart</button>
            </a>
            <!-- Product 2: Golden Vase -->
            <a href="product2.html" class="product-slide">
                <img src="Images/golden-vase.png" alt="Golden Vase">
                <p>Golden Vase</p>
                <p class="price">£149</p>
                <button class="btn">Add to Cart</button>
            </a>
            <!-- Product 3: Luxury Wall Clock -->
            <a href="product3.html" class="product-slide">
                <img src="Images/luxury-wall-clock.png" alt="Luxury Wall Clock">
                <p>Luxury Wall Clock</p>
                <p class="price">£249</p>
                <button class="btn">Add to Cart</button>
            </a>
        </div>
        <button class="slider-btn prev-btn">❮</button>
        <button class="slider-btn next-btn">❯</button>
    </div>
    <!-- Search by name or category -->
    <div class="search-container">
    <form action="{{ route('home-search') }}" method="GET">
        <input 
            type="text" 
            name="query" 
            placeholder="Search for product names or categories..." 
            value="{{ request('query') }}"
            class="search-input"
        >
        <button type="submit" class="search-button">Search</button>
    </form>
    </div>
    <!-- Choose Category -->
    <form method="GET" action="{{ route('product.index') }}">
    <select name="category" onchange="this.form.submit()">
        <option value="">Select a Category</option>
        @foreach ($categories as $category)
            <option value="{{ $category }}" @if(request('category') == $category) selected @endif>
                {{ $category }}
            </option>
        @endforeach
    </select>
    </form>
    @if (request('category'))
        @php
            $filteredProducts = $productInfo->where('category_name', request('category'));
        @endphp
    @else
        @php
            $filteredProducts = $productInfo;
        @endphp
    @endif
    <div class="product-list">
    @if ($query ?? false)
        <h2>Search Results for "{{ $query }}"</h2>
    @endif

    @forelse ($productInfo as $info)
        <div class="product">
            <div class="product-image">
                <img src="{{ asset('images/openart-image_'.$info->product_id.'.jpg') }}" alt="{{ $info->product_name }}">
            </div>
            <div class="product-details">
                <h2>{{ $info->product_name }}</h2>
                <p>{{ $info->description }}</p>
                <p class="product-price">£{{ $info->price }}.00</p>
                <form method="POST" action="{{ route('cart.add') }}">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $info->product_id }}">
                    <input type="hidden" name="product_name" value="{{ $info->product_name }}">
                    <input type="hidden" name="product_price" value="{{ $info->price }}">
                    <button type="submit" class="buy-button">Buy Now</button>
                </form>
            </div>
        </div>
    @empty
        <p>No products found matching your search.</p>
    @endforelse
</div>

@endsection

