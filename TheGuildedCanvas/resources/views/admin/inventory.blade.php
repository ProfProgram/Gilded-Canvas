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
            <div class="inventory-header">
                <button class="update-button" onclick="showAddProductModal()">+ Add Product</button>
                <form method="GET" action="{{ route('admin.inventory') }}" class="search-container">
                    <input type="text" name="search" class="search-bar" placeholder="Search products..." value="{{ request()->search }}">
                </form>
            </div>
        <table class="table">
            <thead>
            <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Price (£)</th>
                <th>Height (cm)</th>
                <th>Width (cm)</th>
                <th>Description</th>
                <th>Category</th>
                <th>Stock Level</th>
		        <th>Stock Incoming</th>
                <th>Stock Outgoing</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($inventory as $item)
                <tr>
                    <td>{{ $item->product->product_id }}</td>
                    <td>{{ $item->product->product_name }}</td>
                    <td>£{{ number_format($item->product->price, 2) }}</td>
                    <td>{{ $item->stock_level }}</td>
                    <td>{{ $item->product->height }}</td>
                        <td>{{ $item->product->width }}</td>
                        <td>{{ $item->product->description }}</td>
                        <td>{{ $item->product->category_name }}</td>
                        <td>{{ $item->stock_level }}</td>
                        <td>{{ $item->stock_incoming}}</td>
                        <td>{{ $item->stock_outgoing}}</td>
                        <td>
                            <button class="update-button" onclick="showEditProductModal({{ json_encode($item->product) }})">Edit</button>
                            <button class="delete-button" onclick="showDeleteProductModal('{{ $item->product->product_id }}')">Delete</button>
                        </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- JavaScript for Modal Handling -->
<script>
function showAddProductModal() {
    document.getElementById("addProductModal").style.display = "block";
}

function closeAddProductModal() {
    document.getElementById("addProductModal").style.display = "none";
}

function showEditProductModal(product) {
    document.getElementById("edit_product_name").value = product.product_name;
    document.getElementById("edit_price").value = product.price;
    document.getElementById("edit_height").value = product.height;
    document.getElementById("edit_width").value = product.width;
    document.getElementById("edit_description").value = product.description;
    document.getElementById("edit_category_name").value = product.category_name;
    document.getElementById("edit_stock_level").value = product.inventory ? product.inventory.stock_level : 0;

    const updateRoute = @json(route('admin.product.update', ['id' =>  '__ID__']));
    document.getElementById("editProductForm").action = updateRoute.replace('__ID__', product.product_id);
    document.getElementById("editProductModal").style.display = "block";
}

function closeEditProductModal() {
    document.getElementById("editProductModal").style.display = "none";
}

function showDeleteProductModal(productId) {
    const deleteRoute = @json(route('admin.product.destroy', ['id' => '__ID__']));
    document.getElementById("deleteProductForm").action = deleteRoute.replace('__ID__', productId);
    document.getElementById("deleteProductModal").style.display = "block";
}

function closeDeleteProductModal() {
    document.getElementById("deleteProductModal").style.display = "none";
}
</script>
@endsection
