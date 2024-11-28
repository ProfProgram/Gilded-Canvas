
@extends('layouts.master')

@section('content')

<!DOCTYPE html>
<body>
    @if (session('status'))
    <div class="alert">
        {{ session('status') }}
        <form method="POST" action="{{ url('/close-alert') }}" style="display: inline;">
            @csrf
            <button type="submit" class="close-btn">✖</button>
        </form>
    </div>
    @endif

    <!-- Left side of this webpage will be the form
    the right will be a fading image that disappears by the time it reaches the closest part of the form -->
    <div id="reviewContent">
        <div id="leftSide">
            <form id="reviewForm" method="POST" action="{{ url('/review') }}">
                @csrf
                <!-- should be an enumeration of all product names -->
                <div id="input-collection">
                <div>
                    <input type="text" id="UserId-txtBox" placeholder="User_id" name="User_id" required>
                </div>
                <div>
                    <label for="ProductId">Product Name:</label>
                    <select name="Product_id" id="ProductId" onchange="updateProductImage()" required>
                    @foreach($prod_names as $prod_name)
                        <option id="prod_name-option" value="{{ $prod_name->Product_id }}" data-image="{{ asset('images/openart-image_' . $prod_name->Product_id . '.jpg') }}">{{ $prod_name->Product_name }}</option>
                    @endforeach
                    </select>
                </div>
                <div>
                    <label for="rating" id="rating-label">Rating:</label>
                    <input type="number" id="rating" min="0" max="5" name="Rating" required>
                </div>
                <div>
                    <textarea id="desc-txtArea" placeholder="Review Description ..." rows="3"
                    onInput="this.parentNode.dataset.value = this.value" name="Review_text" required></textarea>
                </div>
                </div>
                <div>
                    <button type="submit" class="btn-addReview">Add Review</button>
                </div>
            </form>
        </div>
        <!-- image to be based off of the product name (Id) queried to database -->
        <div class="rightSide">
            <img src="{{ asset('images/openart-image_1.jpg') }}" alt="Current seclected product" id="reviewSelectedProduct-image">
        </div>
    </div>
    <!-- Script needs to be on this page (when put in js/js.js the image doesn't update as expected) -->
    <script>
    function updateProductImage() {
        const productDropdown = document.getElementById('ProductId');
        const selectedOption = productDropdown.options[productDropdown.selectedIndex];
        const imageUrl = selectedOption.getAttribute('data-image');
        const imageElement = document.getElementById('reviewSelectedProduct-image');
        imageElement.src = imageUrl;
    }
    </script>
</body>
@endsection