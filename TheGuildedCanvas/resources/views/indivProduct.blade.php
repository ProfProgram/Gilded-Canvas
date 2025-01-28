@extends('layouts.master')

@section('content')

<main class="productDisplay">
    <!-- Order:
        Name,
        Picture,
        Description,
        Dimensions,
        Price per unit,
        Stock of product,
        Quantity to add to cart,
        Add to cart button  
        -->

    <!-- Currently not dynamic :: Needed Tables = PRODUCT; INVENTORY; USER -->
    <h1 class="productName">Product Name</h1>
    <img src="{{ asset('images/products/img-1.png')}}" alt="productName" class="productImg">
    <p class="productDesc">THIS IS A DESCRIPTION</p>
    <p class="productDim">Dimensions: H; 100cm, W; 50cm</p>
    <p class="productPrice">Price: £100</p>
    <p class="productStock">No. in Stock: 150</p>

    <form action="submit" class="addToCart">
        @csrf
        <label for="cartQuan" id="cartQuan-label">Quantity: </label>
        <!-- max value should be stock -->
        <input type="number" id="cartQuan" name="cartQuan_add" value="1" min="1" max="150">
        <input type="hidden" id="productPrice" name="productPrice" value="100">
        <button type="submit" class="btn-AddProductCart">Add To Cart</button>
    </form>
</main>

@endsection