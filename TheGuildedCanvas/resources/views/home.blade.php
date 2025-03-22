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

@if (session('status'))
    <div class="alert">
        <p class="message">{{ session('status') }}</p>
        <form method="POST" action="{{ url('/close-alert') }}" style="display: inline;">
            @csrf
            <button type="submit" class="close-btn">✖</button>
        </form>
    </div>
@endif

<section class="productFilters">
    <h2>Search Our Products</h2>
    <!-- Product Filtering -->
    <div class="search-container">
        <form action="{{ route('product.index') }}" method="GET">
            <!-- Search by name or category -->
            <input
                type="text"
                name="query"
                placeholder="Search for product names or categories..."
                value="{{ request('query') }}"
                class="search-input"
            >
            <!-- Choose Category -->
            <select class="category-select" name="category">
                <option value="" disabled {{ !request('category') ? 'selected' : '' }} hidden>Select a Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category }}" @if(request('category') == $category) selected @endif>{{ $category }}</option>
                @endforeach
            </select>
            <!-- Price filtering -->
            <div class="price-filter">
                <input 
                    type="number" 
                    name="min_price" 
                    placeholder="Min Price" 
                    value="{{ request('min_price') }}"
                    class="price-input"
                >
                <input 
                    type="number" 
                    name="max_price" 
                    placeholder="Max Price" 
                    value="{{ request('max_price') }}"
                    class="price-input"
                >
            </div>
            <button type="submit" class="search-button">Search</button>
        </form>
    </div>

    @php
        $query = request('query');
        $category = request('category');
        $minPrice = request('min_price');
        $maxPrice = request('max_price');

        // Filter products based on query, category, and price
        $filteredProducts = $productInfo->filter(function($product) use ($query, $category, $minPrice, $maxPrice) {
            $matchesQuery = $query ? stripos($product->product_name, $query) !== false || stripos($product->category_name, $query) !== false : true;
            $matchesCategory = $category ? $product->category_name == $category : true;
            $matchesPrice = true;

            if ($minPrice !== null && $maxPrice !== null) {
                $matchesPrice = $product->price >= $minPrice && $product->price <= $maxPrice;
            } elseif ($minPrice !== null) {
                $matchesPrice = $product->price >= $minPrice;
            } elseif ($maxPrice !== null) {
                $matchesPrice = $product->price <= $maxPrice;
            }

            return $matchesQuery && $matchesCategory && $matchesPrice;
        }); 
    @endphp
</section>

<!-- 🖼️ Hero Section -->
<section class="hero" id="home">
    <h1>Welcome to The Gilded Canvas</h1>
    <p>Where art meets elegance. Discover unique and timeless pieces crafted for the discerning collector.</p>
    <a href="{{ url('/product') }}" class="btn">Shop Now</a>
</section>

<!-- 🛍️ Featured Products Section Fixed -->
<section class="products-carousel" id="products-sliders">
    <h2>Featured Products</h2>
    <div class="slider">
        <button class="slider-btn prev-btn">❮</button>
        <div class="slider-track">
            <!-- Product 1 -->
            <a class="product-slide">
                <img src="{{ asset('images/products/img-12.png') }}" alt="Gilded Frame Art">
                <p>Gilded Frame Art</p>
                <p class="price">£199</p>
                <button class="btn">Add to Cart</button>
            </a>
            <!-- Product 2 -->
            <a class="product-slide">
                <img src="{{ asset('images/products/img-13.png') }}" alt="Golden Vase">
                <p>Golden Vase</p>
                <p class="price">£149</p>
                <button class="btn">Add to Cart</button>
            </a>
            <!-- Product 3 -->
            <a class="product-slide">
                <img src="{{ asset('images/products/img-14.png') }}" alt="Luxury Wall Clock">
                <p>Luxury Wall Clock</p>
                <p class="price">£249</p>
                <button class="btn">Add to Cart</button>
            </a>
            <!-- Product 4 -->
            <a class="product-slide">
                <img src="{{ asset('images/products/img-15.png') }}" alt="Golden Candle Holder">
                <p>Golden Candle Holder</p>
                <p class="price">£129</p>
                <button class="btn">Add to Cart</button>
            </a>
            <!-- Product 5 -->
            <a class="product-slide">
                <img src="{{ asset('images/products/img-16.png') }}" alt="Elegant Gold Mirror">
                <p>Elegant Gold Mirror</p>
                <p class="price">£179</p>
                <button class="btn">Add to Cart</button>
            </a>
            <!-- Product 6 -->
            <a class="product-slide">
                <img src="{{ asset('images/products/img-17.png') }}" alt="Art Deco Sculpture">
                <p>Art Deco Sculpture</p>
                <p class="price">£219</p>
                <button class="btn">Add to Cart</button>
            </a>
        </div>
        <button class="slider-btn next-btn">❯</button>
    </div>
</section>

<script>
const sliderTrack = document.querySelector('.slider-track');
const prevBtn = document.querySelector('.prev-btn');
const nextBtn = document.querySelector('.next-btn');

let currentIndex = 0;
const productsPerSlide = 3;
const totalProducts = document.querySelectorAll('.product-slide').length;
const maxIndex = Math.ceil(totalProducts / productsPerSlide) - 1;

function updateSlider() {
    const slideWidth = document.querySelector('.product-slide').offsetWidth;
    sliderTrack.style.transform = `translateX(-${currentIndex * slideWidth * productsPerSlide}px)`;
}

prevBtn.addEventListener('click', () => {
    currentIndex = Math.max(currentIndex - 1, 0);
    updateSlider();
});

nextBtn.addEventListener('click', () => {
    currentIndex = Math.min(currentIndex + 1, maxIndex);
    updateSlider();
});

let autoSlide = setInterval(() => {
    currentIndex = (currentIndex + 1) % (maxIndex + 1);
    updateSlider();
}, 5000);

sliderTrack.addEventListener('mouseover', () => clearInterval(autoSlide));
sliderTrack.addEventListener('mouseout', () => {
    autoSlide = setInterval(() => {
        currentIndex = (currentIndex + 1) % (maxIndex + 1);
        updateSlider();
    }, 5000);
});

window.addEventListener('resize', updateSlider);
</script>
@endsection
