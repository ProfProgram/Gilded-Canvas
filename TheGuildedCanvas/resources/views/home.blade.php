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

<!-- ? Search Section -->
<section class="productFilters">
    <h2>Search Our Products</h2>
    <div class="search-container">
        <form action="{{ route('product.index') }}" method="GET">
            <input type="text" name="query" placeholder="Search for product names or categories..." value="{{ request('query') }}" class="search-input">
            <select class="category-select" name="category">
                <option value="" disabled {{ !request('category') ? 'selected' : '' }} hidden>Select a Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category }}" @if(request('category') == $category) selected @endif>{{ $category }}</option>
                @endforeach
            </select>
            <div class="price-filter">
                <input type="number" name="min_price" placeholder="Min Price" value="{{ request('min_price') }}" class="price-input">
                <input type="number" name="max_price" placeholder="Max Price" value="{{ request('max_price') }}" class="price-input">
            </div>
            <button type="submit" class="search-button">Search</button>
        </form>
    </div>

    @php
        $query = request('query');
        $category = request('category');
        $minPrice = request('min_price');
        $maxPrice = request('max_price');

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

<!-- 🛍️ Featured Products Section -->
<section class="products-carousel" id="products-sliders">
    <h2>Featured Products</h2>
    <div class="slider">
        <button class="slider-btn prev-btn">&#10094;</button>
        <div class="slider-track">
            <a class="product-slide" href="{{ url('/product/Gilded Frame Art') }}">
                <img src="{{ asset('images/products/img-12.png') }}" alt="Gilded Frame Art">
                <p>Gilded Frame Art</p>
                <p class="price">£199</p>
                <form action="{{ route('cart.add') }}" method="POST" style="display: inline;">
                    @csrf
                    <input type="hidden" name="product_id" value="12">
                    <input type="hidden" name="product_name" value="Gilded Frame Art">
                    <input type="hidden" name="price" value="199">
                    <input type="hidden" name="cartQuan_add" value="1">
                    <button type="submit" class="btn">Add to Cart</button>
                </form>
            </a>
            <a class="product-slide" href="{{ url('/product/Golden Bloom Vase') }}">
                <img src="{{ asset('images/products/img-13.png') }}" alt="Golden Bloom Vase">
                <p>Golden Bloom Vase</p>
                <p class="price">£149</p>
                <form action="{{ route('cart.add') }}" method="POST" style="display: inline;">
                    @csrf
                    <input type="hidden" name="product_id" value="13">
                    <input type="hidden" name="product_name" value="Golden Bloom Vase">
                    <input type="hidden" name="price" value="149">
                    <input type="hidden" name="cartQuan_add" value="1">
                    <button type="submit" class="btn">Add to Cart</button>
                </form>
            </a>
            <a class="product-slide" href="{{ url('/product/Luxury Wall Clock') }}">
                <img src="{{ asset('images/products/img-14.png') }}" alt="Luxury Wall Clock">
                <p>Luxury Wall Clock</p>
                <p class="price">£249</p>
                <form action="{{ route('cart.add') }}" method="POST" style="display: inline;">
                    @csrf
                    <input type="hidden" name="product_id" value="14">
                    <input type="hidden" name="product_name" value="Luxury Wall Clock">
                    <input type="hidden" name="price" value="249">
                    <input type="hidden" name="cartQuan_add" value="1">
                    <button type="submit" class="btn">Add to Cart</button>
                </form>
            </a>
            <a class="product-slide" href="{{ url('/product/Classic Brown Frame') }}">
                <img src="{{ asset('images/products/img-15.png') }}" alt="Classic Brown Frame">
                <p>Classic Brown Frame</p>
                <p class="price">£85</p>
                <form action="{{ route('cart.add') }}" method="POST" style="display: inline;">
                    @csrf
                    <input type="hidden" name="product_id" value="15">
                    <input type="hidden" name="product_name" value="Classic Brown Frame">
                    <input type="hidden" name="price" value="85">
                    <input type="hidden" name="cartQuan_add" value="1">
                    <button type="submit" class="btn">Add to Cart</button>
                </form>
            </a>
            <a class="product-slide" href="{{ url('/product/Calm Figure') }}">
                <img src="{{ asset('images/products/img-16.png') }}" alt="Calm Figure">
                <p>Calm Figure</p>
                <p class="price">£55</p>
                <form action="{{ route('cart.add') }}" method="POST" style="display: inline;">
                    @csrf
                    <input type="hidden" name="product_id" value="16">
                    <input type="hidden" name="product_name" value="Calm Figure">
                    <input type="hidden" name="price" value="55">
                    <input type="hidden" name="cartQuan_add" value="1">
                    <button type="submit" class="btn">Add to Cart</button>
                </form>
            </a>
            <a class="product-slide" href="{{ url('/product/Quite Strength') }}">
                <img src="{{ asset('images/products/img-17.png') }}" alt="Quite Strength">
                <p>Quite Strength</p>
                <p class="price">£50</p>
                <form action="{{ route('cart.add') }}" method="POST" style="display: inline;">
                    @csrf
                    <input type="hidden" name="product_id" value="17">
                    <input type="hidden" name="product_name" value="Quite Strength">
                    <input type="hidden" name="price" value="50">
                    <input type="hidden" name="cartQuan_add" value="1">
                    <button type="submit" class="btn">Add to Cart</button>
                </form>
            </a>
        </div>
        <button class="slider-btn next-btn">&#10095;</button>
    </div>
</section>

<!-- ⭐ Latest Reviews Section -->
<section class="user-reviews py-5" style="background-color: #fff;">
    <h2 class="text-center mb-4" style="font-size: 2rem; color: #1A1A1A;">Reviews From Our Customers</h2>
    <div class="container">
        <div class="row g-4 justify-content-center">
            @foreach ($reviews as $review)
                <div class="col-md-6 col-lg-4 d-flex">
                    <div class="card text-center p-4 shadow-sm w-100" style="border-radius: 12px; border: 1px solid #eee;">
                        <h5 style="color: #d4af37; font-weight: bold;">
                            Rating: {!! str_repeat('★', $review->rating) !!}{!! str_repeat('☆', 5 - $review->rating) !!}
                        </h5>
                        <p style="font-size: 1rem; color: #333;">
                            Ease of Use: {!! str_repeat('★', $review->ease_of_use) !!}{!! str_repeat('☆', 5 - $review->ease_of_use) !!}<br>
                            Checkout: {!! str_repeat('★', $review->checkout_process) !!}{!! str_repeat('☆', 5 - $review->checkout_process) !!}<br>
                            Product Info: {!! str_repeat('★', $review->product_info) !!}{!! str_repeat('☆', 5 - $review->product_info) !!}<br>
                            Delivery Experience: {!! str_repeat('★', $review->delivery_experience) !!}{!! str_repeat('☆', 5 - $review->delivery_experience) !!}<br>
                            Customer Support: {!! str_repeat('★', $review->customer_support) !!}{!! str_repeat('☆', 5 - $review->customer_support) !!}
                        </p>
                        <p style="font-size: 0.95rem; color: #555;">
                            <strong>Best Feature:</strong> {{ $review->best_feature }}<br>
                            <strong>Improvement Area:</strong> {{ $review->improvement_area }}<br>
                            <strong>Recommend to Others?</strong> {{ $review->recommend }}
                        </p>
                        <p class="mt-3" style="font-style: italic; color: #555;">
                            {{ $review->review_text ?? 'No written review' }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
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
