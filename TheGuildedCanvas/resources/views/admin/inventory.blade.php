@extends('layouts.master')

@section('content')
@php
$categories = $inventory->filter(fn($item) => $item->product)->pluck('product.category_name')->unique()->toArray();
@endphp
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
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
        <h1>Inventory Management</h1>
        <!-- Product Filtering -->
        <div class="search-container">
        <form action="{{ route('inventory-search') }}" method="GET">
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
                <option value="" disabled @if(!request('category')) selected @endif hidden>Select a Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category }}" @if(request('category') == $category) selected @endif>{{ $category }}</option>
                @endforeach
            </select>

            <!-- Price filtering -->
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

            <button type="submit" class="search-button">Search</button>
        </form>
        </div>

        @php
            $query = request('query');
            $category = request('category');
            $minPrice = request('min_price');
            $maxPrice = request('max_price');

            // Filter inventory based on query, category, and price
            $filteredInventory = $inventory->filter(function ($item) use ($query, $category, $minPrice, $maxPrice) {
                $product = $item->product;

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

        <div class="inventory-list">
            @if ($query || $category || $minPrice || $maxPrice)
                <h4 style="justify-self: center;">
                    Showing Inventory 
                    @if ($query) matching search "{{ $query }}" @endif
                    @if ($category) in category "{{ $category }}" @endif
                    @if ($minPrice || $maxPrice)
                        with price 
                        @if ($minPrice) min: £{{ $minPrice }} @endif 
                        @if ($maxPrice) max: £{{ $maxPrice }} @endif
                    @endif
                </h4>
            @endif
                <table class="table">
                <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Product Price</th>
                    <th>Stock Level</th>
                    <th>Stock Incoming</th>
                    <th>Stock Outgoing</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($filteredInventory as $item)
                    <tr>
                        <td>{{ $item->product->product_name }}</td>
                        <td>{{ $item->product->price }}</td>
                        <td>
                            <form action="{{ route('admin.inventory.update', $item->inventory_id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                                <input type="number" name="stock_level" value="{{ $item->stock_level }}" class="form-control" style="width: 100px;" required>
                                <button type="submit" class="logout-link">Update</button>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('admin.inventory.update.incoming', $item->inventory_id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                                <input type="number" name="stock_incoming" value="{{ $item->stock_incoming }}" class="form-control" style="width: 100px;" required>
                                <button type="submit" class="logout-link">Update</button>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('admin.inventory.update.outgoing', $item->inventory_id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                                <input type="number" name="stock_outgoing" value="{{ $item->stock_outgoing }}" class="form-control" style="width: 100px;" required>
                                <button type="submit" class="logout-link">Update</button>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('admin.inventory.destroy', $item->inventory_id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="logout-link">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No inventory items match your search criteria.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
