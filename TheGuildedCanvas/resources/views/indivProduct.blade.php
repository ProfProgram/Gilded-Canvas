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

    <!-- Testing data handover -->
    <!-- {{ $productInfo }}
    {{ $inventoryInfo}} -->
    <!--  -->

    <section class="product-info">
        <h1 class="productName">{{$productInfo->product_name}}</h1>
        <div class="productImg-Container">
            <img src="{{ asset('images/products/img-'.$productInfo->product_id.'.png') }}" alt="productName" class="productImg">
        </div>
        <p class="productDesc">{{$productInfo->description}}</p>
        <p class="productDim">Dimensions: H; {{$productInfo->height}}cm, W; {{$productInfo->width}}cm</p>
        <p class="productPrice">Price: £{{$productInfo->price}}</p>
        <p class="productStock">No. in Stock: {{$inventoryInfo->stock_level}}</p>

        <form action="{{ route('cart.add') }}" class="addToCart" method="POST">
            @csrf
            <label for="cartQuan" id="cartQuan-label">Quantity: </label>
            <input type="number" id="cartQuan" name="cartQuan_add" value="1" min="1" max="{{$inventoryInfo->stock_level}}">
            <input type="hidden" name="price" value="{{$productInfo->price}}">
            <input type="hidden" name="product_name" value="{{$productInfo->product_name}}">
            <input type="hidden" name="product_id" value="{{$productInfo->product_id}}">
            <button type="submit" class="btn-AddProductCart">Add To Cart</button>
        </form>
    </section>

    <!-- REVIEW LIST SECTION -->

    <!-- Review data check -->
    <!-- {{ $reviewInfo }} -->
    <!--  -->
    <section class="review-list">
        <h1 class="ReviewList-title">Reviews:</h1>
        <button class="MakeReview" onclick="window.location.href='{{ url('/review') }}'">Leave a Review</button>
        <div class="ReviewList">
            @foreach ($reviewInfo as $review)
                <div class="review">
                    <p id="reviewUser">Users Name: {{$review->name}}</p>
                    <p id="reviewCreated">Created: {{$review->review_date}}</p>
                    <p id="reviewRating">Rating: {{$review->rating}}</p>
                    <p id="reviewText">{{$review->review_text}}</p>
                </div>
            @endforeach
        </div>
    </section>
</main>

<style>
    .productDisplay {
    }
    .productImg-Container {
        height: 200px;
        width: 200px;
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
    }
    .productImg-Container img {
        height: 100%;
        width: 100%;
        background-size: cover;
        transition: 1s;
        cursor: zoom-in;
    }
    .productImg-Container img:active {
        transform: scale(1.5);
    }
</style>
@endsection