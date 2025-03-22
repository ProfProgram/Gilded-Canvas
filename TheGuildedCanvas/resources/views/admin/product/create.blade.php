@extends('layouts.master')

@section('content')
<div class="container">
    <h2 class="mb-4">Add New Product</h2>

    <!-- Display success message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Display validation errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('product.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="product_name">Product Name:</label>
            <input type="text" name="product_name" id="product_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="price">Price (£):</label>
            <input type="number" name="price" id="price" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="height">Height (cm):</label>
            <input type="number" name="height" id="height" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="width">Width (cm):</label>
            <input type="number" name="width" id="width" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea name="description" id="description" class="form-control" required></textarea>
        </div>

        <div class="form-group">
            <label for="category_name">Category Name:</label>
            <input type="text" name="category_name" id="category_name" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-warning mt-3" 
                style="background-color: #d4af37; color: #1A1A1A; font-weight: bold;">
            Add Product
        </button>
    </form>
</div>
@endsection
