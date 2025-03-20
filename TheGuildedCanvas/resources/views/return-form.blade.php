@extends('layouts.master')

@section('content')

<div class="container">
    <h2 class="page-title">Return Request Form</h2>

    <!-- Display success message -->
    @if(session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <!-- Show pending message if return is already requested -->
    @if(isset($return_status) && $return_status === 'pending')
        <div class="alert alert-info">
            Your return request has been submitted and is pending.
        </div>
    @else
        <!-- Show return form if request is NOT pending -->
        <form action="{{ route('return.submit', ['order_id' => $order_id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label for="order_id">Order ID:</label>
            <input type="text" name="order_id" value="{{ $order_id }}" readonly>

            <label for="product_ids">Select Products:</label>
            <select name="product_ids[]" id="product_ids" class="custom-select" multiple required>
                @foreach ($orderDetails as $product)
                    <option value="{{ $product->product_id }}" 
                            data-image="{{ asset('images/products/img-'.$product->product_id.'.png') }}" 
                            data-quantity="{{ $product->quantity }}">
                        {{ $product->product_name }} (Qty: {{ $product->quantity }})
                    </option>
                @endforeach
            </select>

            <label for="return_images">Upload Images (Optional):</label>
            <input type="file" name="return_images[]" multiple accept="image/*" class="form-control">

            <label for="reason">Reason for Return:</label>
            <textarea name="reason" id="reason" required></textarea>

            <button type="submit" class="return-button" id="submit-btn">
                <span id="submit-text">Submit Return Request</span>
                <span id="loading-spinner" class="spinner-border spinner-border-sm" style="display: none;"></span>
            </button>

            <h3>Selected Products for Return:</h3>
            <ul id="product-preview"></ul>
        </form>
    @endif
</div>

<!-- Include jQuery (Required for Select2) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include Select2 JS & CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('#product_ids').select2({
            placeholder: "Select products to return",
            allowClear: true,
            templateResult: formatProduct,
            templateSelection: formatProduct
        });

        function formatProduct(product) {
            if (!product.id) return product.text;
            let imageUrl = $(product.element).data('image') || '{{ asset("storage/default.png") }}';
            return $('<span><img src="' + imageUrl + '" class="product-img"/> ' + product.text + '</span>');
        }

        $("#product_ids").on("change", function() {
            $("#product-preview").html("");
            $(this).find("option:selected").each(function() {
                let imageUrl = $(this).data("image") || '{{ asset("storage/default.png") }}';
                let productName = $(this).text();
                $("#product-preview").append(
                    `<li><img src="${imageUrl}" class="product-img-preview"> ${productName}</li>`
                );
            });
        });

        $("form").on("submit", function() {
            $("#submit-text").text("Submitting...");
            $("#loading-spinner").show();
            $("button[type=submit]").prop("disabled", true);
        });

        $("input, textarea, select").on("change keyup", function() {
            if ($(this).val().trim() === "") {
                $(this).addClass("error-input");
            } else {
                $(this).removeClass("error-input");
            }
        });
    });
</script>

<style>
    /* Product Image Preview */
    .product-img-preview, .product-img {
        width: 50px;
        height: 50px;
        border-radius: 5px;
        margin-right: 10px;
    }

    /* Error Highlighting */
    .error-input {
        border: 2px solid red !important;
        background-color: #ffe6e6;
    }

    /* Select2 Styling */
    .select2-container {
        width: 100% !important;
    }

    .select2-selection--multiple {
        min-height: 40px;
        border-radius: 5px;
        border: 1px solid #ccc;
        padding: 5px;
        font-size: 16px;
        background-color: #fff;
    }

    .select2-selection__choice {
        background-color: #eed9a4 !important;
        color: black !important;
        padding: 5px 10px;
        border-radius: 5px;
        font-weight: bold;
    }

    .select2-selection__choice__remove {
        display: none;
    }

    /* Bigger Submit Button */
    .return-button {
        background-color: #d4af37; /* Gold */
        color: black;
        padding: 14px 22px;
        border: none;
        border-radius: 50px;
        font-size: 1.4rem;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        margin-top: 15px;
        width: 100%;
        text-align: center;
    }

    .return-button:hover {
        background-color: #b08a2e;
    }

    /* Selected Products for Return Section */
    #product-preview {
        margin-top: 20px;
        padding: 20px;
        background-color: #eed9a4; /* Beige */
        border-radius: 8px;
        border: 2px solid #d4af37;
    }

    #product-preview li {
        display: flex;
        align-items: center;
        gap: 20px;
        font-size: 1.3rem;
        font-weight: bold;
    }

    /* Enlarged Product Image in Selected Section */
    .product-img-preview {
        width: 100px;
        height: 100px;
        border-radius: 5px;
        object-fit: cover;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .container {
            padding: 30px;
        }

        .page-title {
            font-size: 2rem;
        }

        .product-img, .product-img-preview {
            width: 80px;
            height: 80px;
        }
    }
</style>

@endsection

