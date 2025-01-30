
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
<div class="container">
    <div class="product-header">
        <h1>Product Page</h1>
    </div>
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
        <select name="category">
            <option value="">Select a Category</option>
            @foreach ($categories as $category)
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

    <div class="product-list">
        @if ($query || $category)
            <h2>Search Results for "{{ $query }}" in "{{ $category }}" category</h2>
        @endif

        @forelse ($filteredProducts as $info)
            <div class="product">
                <div class="product-image">
                    <img src="{{ asset('images/products/img-'.$info->product_id.'.png') }}" alt="{{ $info->product_name }}" onclick="window.location.href='{{ url('/product/'.$info->product_name.'') }}'">
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
                        <input type="hidden" name="cartQuan_add" value="1">
                        <button type="submit" class="buy-button">Buy Now</button>
                    </form>
                </div>
            </div>
        @empty
            <p>No products found matching your search.</p>
        @endforelse
    </div>
</div>
<style>
    .product-image {
        position: relative;
    }

    .product-image img {
        transition: opacity 0.3s ease-in-out;
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
    }
</style>
@endsection
