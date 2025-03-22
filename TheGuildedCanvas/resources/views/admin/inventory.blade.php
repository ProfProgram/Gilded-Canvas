@extends('layouts.master')

@section('content')
<div class="container inventory-management">
    <h2 class="page-title">Inventory Management</h2>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="inventory-header">
        <button class="update-button" onclick="showAddProductModal()">+ Add Product</button>
        <form method="GET" action="{{ route('admin.inventory') }}" class="search-container">
            <input type="text" name="search" class="search-bar"
                   placeholder="Search products..." 
                   value="{{ request()->search }}">
        </form>
    </div>

    <!-- Inventory Table -->
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Product Name</th>
                <th>Price (£)</th>
                <th>Height (cm)</th>
                <th>Width (cm)</th>
                <th>Description</th>
                <th>Category</th>
                <th>Stock Level</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @if($products->isEmpty())
                <tr>
                    <td colspan="9" class="no-results">No products found.</td>
                </tr>
            @else
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->product_name }}</td>
                        <td>£{{ number_format($product->price, 2) }}</td>
                        <td>{{ $product->height }}</td>
                        <td>{{ $product->width }}</td>
                        <td>{{ $product->description }}</td>
                        <td>{{ $product->category_name }}</td>
                        <td>{{ optional($product->inventory)->stock_level ?? 0 }}</td>
                        <td>
                            <button class="update-button" onclick="showEditProductModal({{ json_encode($product) }})">Edit</button>
                            <button class="delete-button" onclick="showDeleteProductModal({{ $product->id }})">Delete</button>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>

<!-- Add Product Modal -->
<div id="addProductModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeAddProductModal()">&times;</span>
        <h3>Add New Product</h3>
        <form id="addProductForm" method="POST" action="{{ route('product.store') }}">
            @csrf
            <input type="text" name="product_name" placeholder="Product Name" required>
            <input type="number" name="price" placeholder="Price (£)" step="0.01" required>
            <input type="number" name="height" placeholder="Height (cm)" required>
            <input type="number" name="width" placeholder="Width (cm)" required>
            <input type="text" name="description" placeholder="Description" required>
            <input type="text" name="category_name" placeholder="Category" required>
            <input type="number" name="stock_level" placeholder="Stock Level" required>
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
            <input type="hidden" id="edit_product_id" name="product_id">
            <input type="text" id="edit_product_name" name="product_name" placeholder="Product Name" required>
            <input type="number" id="edit_price" name="price" placeholder="Price (£)" step="0.01" required>
            <input type="number" id="edit_height" name="height" placeholder="Height (cm)" required>
            <input type="number" id="edit_width" name="width" placeholder="Width (cm)" required>
            <input type="text" id="edit_description" name="description" placeholder="Description" required>
            <input type="text" id="edit_category_name" name="category_name" placeholder="Category" required>
            <input type="number" id="edit_stock_level" name="stock_level" placeholder="Stock Level" required>
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

<!-- JavaScript for Modal Handling -->
<script>
function showAddProductModal() {
    document.getElementById("addProductModal").style.display = "block";
}

function closeAddProductModal() {
    document.getElementById("addProductModal").style.display = "none";
}

function showEditProductModal(product) {
    document.getElementById("edit_product_id").value = product.id;
    document.getElementById("edit_product_name").value = product.product_name;
    document.getElementById("edit_price").value = product.price;
    document.getElementById("edit_height").value = product.height;
    document.getElementById("edit_width").value = product.width;
    document.getElementById("edit_description").value = product.description;
    document.getElementById("edit_category_name").value = product.category_name;
    document.getElementById("edit_stock_level").value = product.inventory ? product.inventory.stock_level : 0;
    document.getElementById("editProductForm").action = "/admin/product/update/" + product.id;
    document.getElementById("editProductModal").style.display = "block";
}

function closeEditProductModal() {
    document.getElementById("editProductModal").style.display = "none";
}

function showDeleteProductModal(productId) {
    document.getElementById("deleteProductForm").action = "/admin/product/delete/" + productId;
    document.getElementById("deleteProductModal").style.display = "block";
}

function closeDeleteProductModal() {
    document.getElementById("deleteProductModal").style.display = "none";
}
</script>

@endsection
