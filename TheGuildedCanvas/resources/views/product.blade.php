
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
<div class="container">
    <div class="product-header">
        <h1>Product Page</h1>
    </div>
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
            <option value="" disabled 
            @if(!request('category')) selected @endif
            hidden>Select a Category</option>
            @foreach ($categories as $category)
                <option value="{{ $category }}" @if(request('category') == $category) selected @endif>
                    {{ $category }}
                </option>
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
            $matchesPrice = true; // Default to true if no price filtering is done

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

<div class="product-list">
    @if ($query || $category || $minPrice || $maxPrice)
        <h4 style="justify-self: center;">
            @php
                $searchStatement = "Searching Products for products ";
                // adding query to statement
                if ($query !== null) {
                    $searchStatement .= "with a name-likeness to '{$query}' ";
                }

                // adding category to statement
                if ($category != null) {
                    $searchStatement .= "within category {$category} ";
                }

                // adding price filter to statement
                if ($minPrice !== null && $maxPrice !== null) {
                    $searchStatement .= "within £{$minPrice} - £{$maxPrice} ";
                } elseif ($minPrice !== null) {
                    $searchStatement .= "within £{$minPrice} - MAX ";
                } elseif ($maxPrice !== null) {
                    $searchStatement .= "within MIN - £{$maxPrice} ";
                }
            @endphp
            {{ $searchStatement }}
        </h4>
    @endif

    @forelse ($productInfo as $info)
    @if ($info->inventory && $info->inventory->stock_level > 0)
        <div class="product">
            <div class="product-image">
                <img src="{{ asset('images/products/img-'.$info->product_id.'.png') }}" 
                    alt="{{ $info->product_name }}" onclick="window.location.href='{{ url('/product/'.$info->product_name.'') }}'">
            </div>
            <div class="prod-page-details">
                <h2>{{ $info->product_name }}</h2>
                <p>{{ $info->description }}</p>
                <p class="product-price">£{{ number_format($info->price, 2) }}</p>
                <form method="POST" action="{{ route('cart.add') }}">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $info->product_id }}">
                    <input type="hidden" name="product_name" value="{{ $info->product_name }}">
                    <input type="hidden" name="price" value="{{ $info->price }}">
                    <input type="hidden" name="cartQuan_add" value="1">
                    <button type="submit" class="buy-button">Buy Now</button>
                </form>
            </div>
        </div>
        @endif
        @empty
            <p style="justify-self: center;">No products found matching your search.</p>
        @endforelse
    </div>
</div>
<style>
    .product-image {
        position: relative;
    }

    .product-image img {
        transition: opacity 0.3s ease-in-out;
        z-index: 1;
    }

    .product-image:hover img {
        opacity: 0.6;
    }

    .product-image:hover::after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.2);
        z-index: 0;
        pointer-events: none;
    }
</style>
@endsection
