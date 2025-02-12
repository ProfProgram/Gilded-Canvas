
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
<!-- Hero Section -->
<section class="hero" id="home">
    <h1>Welcome to The Gilded Canvas</h1>
    <p>Where art meets elegance. Discover unique and timeless pieces crafted for the discerning collector.</p>
    <a href="{{url('/product')}}" class="btn">Shop Now</a>
</section>

<!-- Product Slider Section -->
<section class="products-carousel" id="products-sliders">
    <h2>Featured Products</h2>
    <div class="slider">
        <div class="slider-track">
            <!-- anchors will let us connect images with the associated product pages -->
            <a class="product-slide">
                <img src="{{asset('images/products/img-12.png')}}" alt="Gilded Frame Art">
                <p>Gilded Frame Art</p>
                <p class="price">£199</p>
                <button class="btn">Add to Cart</button>
            </a>
            <a class="product-slide">
                <img src="{{asset('images/products/img-13.png')}}" alt="Golden Vase">
                <p>Golden Vase</p>
                <p class="price">£149</p>
                <button class="btn">Add to Cart</button>
            </a>
            <a class="product-slide">
                <img src="{{asset('images/products/img-14.png')}}" alt="Luxury Wall Clock">
                <p>Luxury Wall Clock</p>
                <p class="price">£249</p>
                <button class="btn">Add to Cart</button>
            </a>
        </div>
        <button class="slider-btn prev-btn">❮</button>
        <button class="slider-btn next-btn">❯</button>
    </div>
</section>
<section class="productFilters">
    <h2>Search Our Products</h2>
    <!-- Product Filtering -->
    <div class="search-container">
        <form action="{{ route('product-search') }}" method="GET">
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
                @foreach ($categories as $category)
                    <option value="" disabled 
                        @if(!request('category')) selected @endif 
                        hidden>Select a Category</option>
                        <option value="{{ $category }}" @if(request('category') == $category) selected @endif>
                            {{ $category }}
                        </option>
                @endforeach
            </select>
            <button type="submit" class="search-button">Search</button>
        </form>
    </div>
    @php
        $query = request('query');
        $category = request('category');

        // Filter products based on query and category
        $filteredProducts = $productInfo->filter(function($product) use ($query, $category) {
            $matchesQuery = $query ? stripos($product->product_name, $query) !== false || stripos($product->category_name, $query) !== false : true;
            $matchesCategory = $category ? $product->category_name == $category : true;

            return $matchesQuery && $matchesCategory;
        });
    @endphp
</section>
<style>
</style>

<script>
    const sliderTrack = document.querySelector('.slider-track');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');

    let currentIndex = 0;

    function updateSlider() {
        const slideWidth = document.querySelector('.product-slide').offsetWidth;
        sliderTrack.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
    }

    prevBtn.addEventListener('click', () => {
        currentIndex = Math.max(currentIndex - 1, 0);
        updateSlider();
    });

    nextBtn.addEventListener('click', () => {
        const totalSlides = document.querySelectorAll('.product-slide').length;
        const maxIndex = totalSlides - Math.floor(sliderTrack.clientWidth / document.querySelector('.product-slide').clientWidth);
        currentIndex = Math.min(currentIndex + 1, maxIndex);
        updateSlider();
    });

    window.addEventListener('resize', updateSlider);
    // Auto-slide functionality
    let autoSlide = setInterval(() => {
        const totalSlides = document.querySelectorAll('.product-slide').length;
        currentIndex = (currentIndex + 1) % totalSlides;
        updateSlider();
    }, 5000);

    sliderTrack.addEventListener('mouseover', () => clearInterval(autoSlide));
    sliderTrack.addEventListener('mouseout', () => {
        autoSlide = setInterval(() => {
            const totalSlides = document.querySelectorAll('.product-slide').length;
            currentIndex = (currentIndex + 1) % totalSlides;
            updateSlider();
        }, 5000);
    });
</script>

@endsection

