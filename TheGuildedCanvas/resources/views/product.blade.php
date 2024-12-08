
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
    <div class="search-container">
    <form action="{{ route('product-search') }}" method="GET">
        <input 
            type="text" 
            name="query" 
            placeholder="Search for product names or categories..." 
            value="{{ request('query') }}"
            class="search-input"
        >
        <button type="submit" class="search-button">Search</button>
    </form>
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
