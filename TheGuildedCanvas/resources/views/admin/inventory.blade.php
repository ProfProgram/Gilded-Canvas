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
                    <td>{{ $item->product->height }}</td>
                        <td>{{ $item->product->width }}</td>
                        <td>{{ $item->product->description }}</td>
                        <td>{{ $item->product->category_name }}</td>
                        <td>{{ $item->stock_level }}</td>
                        <td>{{ $item->stock_incoming}}</td>
                        <td>{{ $item->stock_outgoing}}</td>
                        <td>
                            <button class="update-button" onclick="showEditProductModal({{ json_encode($item) }})">Edit</button>
                            <button class="delete-button" onclick="showDeleteProductModal('{{ $item->product->product_id }}')">Delete</button>
                        </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div id="addProductModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeAddProductModal()">&times;</span>
            <h3>Add New Product</h3>
            <form id="addProductForm" method="POST" action="{{ route('product.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="text" name="product_name" placeholder="Product Name" required>
                <input type="number" name="price" placeholder="Price (£)" step="0.01" required>
                <input type="number" name="height" placeholder="Height (cm)" required>
                <input type="number" name="width" placeholder="Width (cm)" required>
                <input type="text" name="description" placeholder="Description" required>
                <input type="text" name="category_name" placeholder="Category" required>
                <input type="number" name="stock_level" placeholder="Stock Level" required>
                <input type="number" name="stock_incoming" placeholder="Stock incoming" required>
                <input type="number" name="stock_outgoing" placeholder="Stock outgoing" required>
                <input type="file" name="product_image" accept=".png" placeholder="File names will be overwritten when saved.png" required>
                <button type="submit" class="update-button">Add Product</button>
            </form>
        </div>
    </div>

    <!-- Edit Product Modal -->
    <div id="editProductModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditProductModal()">&times;</span>
            <h3>Edit Product Details</h3>
            <form id="editProductForm" method="POST" action="">
                @csrf
                @method('PUT')
                <input type="text" id="edit_product_name" name="product_name" placeholder="Product Name" required>
                <input type="number" id="edit_price" name="price" placeholder="Price (£)" step="0.01" required>
                <input type="number" id="edit_height" name="height" placeholder="Height (cm)" required>
                <input type="number" id="edit_width" name="width" placeholder="Width (cm)" required>
                <input type="text" id="edit_description" name="description" placeholder="Description" required>
                <input type="text" id="edit_category_name" name="category_name" placeholder="Category" required>
                <input type="number" id="edit_stock_level" name="stock_level" placeholder="Stock Level" required>
                <input type="number" id="edit_stock_incoming" name="stock_incoming" placeholder="Stock Incoming" required>
                <input type="number" id="edit_stock_outgoing" name="stock_outgoing" placeholder="Stock Outgoing" required>
                <button type="submit" class="update-button">Update Product</button>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteProductModal" class="modal">
        <div class="modal-content">
            <h3>Are you sure?</h3>
            <p>Do you really want to delete this product? This action cannot be undone.</p>
            <form id="deleteProductForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <button type="submit" class="update-button">Yes, Delete</button>
                <button type="button" class="update-button cancel-button" onclick="closeDeleteProductModal()">Cancel</button>
            </form>
        </div>
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

function showEditProductModal(item) {
    document.getElementById("edit_product_name").value = item.product.product_name;
    document.getElementById("edit_price").value = item.product.price;
    document.getElementById("edit_height").value = item.product.height;
    document.getElementById("edit_width").value = item.product.width;
    document.getElementById("edit_description").value = item.product.description;
    document.getElementById("edit_category_name").value = item.product.category_name;
    document.getElementById("edit_stock_level").value = item.stock_level ?? 0;
    document.getElementById("edit_stock_incoming").value = item.stock_incoming ?? 0;
    document.getElementById("edit_stock_outgoing").value = item.stock_outgoing ?? 0;

    const updateRoute = @json(route('admin.product.update', ['id' => '__ID__']));
    document.getElementById("editProductForm").action = updateRoute.replace('__ID__', item.product.product_id);
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
