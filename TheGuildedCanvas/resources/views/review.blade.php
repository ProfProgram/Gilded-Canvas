
@extends('layouts.master')

@section('content')

<body>
    <link rel="navbar" href="{{ asset('navbar.blade.php') }}">
    @if (session('status'))
        <h6 class="alert"> {{ session('status') }} </h6>
    @endif
    <!-- Left side of this webpage will be the form
    the right will be a fading image that disappears by the time it reaches the closest part of the form -->
    <div id="leftSide">
        <form id="reviewForm" method="POST" action="{{ url('/review') }}">
            @csrf
            <!-- should be an enumeration of all product names -->
            <div id="input-collection">
            <div>
                <input type="text" id="UserId-txtBox" placeholder="User_id" name="User_id">
            </div>
            <div>
                <label for="ProductId">Product Name:</label>
                <select name="Product_names" id="ProductId">
                @foreach($prod_names as $prod_name)
                    <option id="prod_name-option" value="{{ $prod_name->Product_id }}" name="Product_id">{{ $prod_name->Product_name }}</option>
                @endforeach
                </select>
                <!-- <input type="number" id="ProductId" placeholder="ProductId" name="Product_name"> -->
            </div>
            <div>
                <label for="rating" id="rating-label">Rating:</label>
                <input type="number" id="rating" min="0" max="5" name="Rating">
            </div>
            <div>
                <textarea id="desc-txtArea" placeholder="Review Description ..." rows="3"
                onInput="this.parentNode.dataset.value = this.value" name="Review_text"></textarea>
            </div>
            </div>
            <div>
                <button type="submit" class="btn-addReview">Add Review</button>
            </div>
        </form>
    </div>
    <!-- image to be based off of the product name (Id) queried to database -->
    <div class="rightSide">
        <img>
    </div>
</body>
@endsection