@extends('layouts.master')

@section('content')
<div class="container">
    <h2 class="mb-4">Rate Your Experience on The Gilded Canvas</h2>

    <form action="{{ route('website.review.store') }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label for="rating">Your Rating:</label>
            <select name="rating" id="rating" class="form-control" required>
                <option value="5">⭐⭐⭐⭐⭐ (Excellent)</option>
                <option value="4">⭐⭐⭐⭐ (Good)</option>
                <option value="3">⭐⭐⭐ (Average)</option>
                <option value="2">⭐⭐ (Poor)</option>
                <option value="1">⭐ (Terrible)</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="review_text">Your Feedback (optional):</label>
            <textarea name="review_text" id="review_text" class="form-control" rows="4" maxlength="1000" placeholder="Tell us about your experience..."></textarea>
        </div>

        <button type="submit" class="btn btn-success">Submit Review</button>
    </form>
</div>
@endsection
