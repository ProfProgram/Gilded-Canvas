@extends('layouts.master')

@section('content')
<div class="container">
    <h2 class="page-title">Return Request Form</h2>

    <form action="{{ url('/submit-return-request') }}" method="POST">
        @csrf
        <label for="order_id">Order ID:</label>
        <input type="text" name="order_id" value="{{ $order_id }}" readonly>

        <<label for="product_ids">Select Products:</label>
<select name="product_ids[]" id="product_ids" class="custom-select" multiple required>
    @foreach ($orderDetails as $product)
        <option value="{{ $product->product_id }}">{{ $product->product_name }}</option>
    @endforeach
</select>

        <label for="reason">Reason for Return:</label>
        <textarea name="reason" id="reason" required></textarea>

        <button type="submit" class="return-button">Submit Return Request</button>
    </form>
</div>
        <script>
    document.getElementById('product_ids').addEventListener('mousedown', function(e) {
        e.preventDefault();
        let select = this;
        let scroll = select.scrollTop;

        e.target.selected = !e.target.selected;

        setTimeout(() => {
            select.scrollTop = scroll;
        }, 0);

        this.dispatchEvent(new Event('change'));
    });
</script>
<!-- Include Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">

<!-- Include jQuery (Required for Select2) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('#product_ids').select2({
            placeholder: "Select products to return",
            allowClear: true
        });
    });
</script>
<style>
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
        background-color: #b22222 !important; /* Dark Red */
        color: white !important;
        padding: 5px 10px;
        border-radius: 5px;
        font-weight: bold;
    }

    .select2-selection__choice__remove {
        color: white !important;
        margin-left: 5px;
        cursor: pointer;
    }
</style>

@endsection
