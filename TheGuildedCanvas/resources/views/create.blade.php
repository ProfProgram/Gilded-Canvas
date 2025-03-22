@extends('layouts.master')
	
	@section('content')
	<!-- Add this link tag at the top inside your Blade file -->
	<link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700;900&display=swap" rel="stylesheet">
	
	<div class="container my-5">
	    <div class="text-center mb-5">
	        <h1 class="fw-bolder display-1" style="font-size: 2.5rem; font-weight: 800;">
	    Rate Your Experience on <span class="text-warning">The Gilded Canvas</span>
	</h1>
	
	          <p class="lead" style="max-width: 800px; margin: auto;font-size: 1rem; font-weight: 225;"">Your feedback helps us improve our services and provide the best experience for our customers.</p>
	    
	    </div>
	@if(session('success'))
	    <div class="alert alert-success text-center fw-bold" style="font-size: 0.6rem; color: white;">
	        {{ session('success') }}
	    </div>
	@endif
	
	    <form action="{{ route('website.review.store') }}" method="POST" style="max-width: 500px; margin: auto;">
	        @csrf
	
	        {{-- ⭐ Star Rating Styles --}}
	        <style>
	            .star-container {
	                display: flex;
	                justify-content: center;
	                align-items: center;
	                flex-direction: row-reverse; /* Right-to-left fill */
	                gap: 7.5px;
	                font-size: 30px; /* Increased star size */
	            }
	            .star-container input {
	                display: none;
	            }
	            .star-container label {
	                cursor: pointer;
	                color: lightgray;
	                transition: color 0.3s ease-in-out;
	            }
	            .star-container input:checked ~ label,
	            .star-container label:hover,
	            .star-container label:hover ~ label {
	                color: gold;
	            }
	            .form-group {
	                margin-bottom: 15px;
	            }
	            .form-label {
	                font-size: 0.9rem;
	                font-weight: bold;
	                text-align: center;
	                display: block;
	                margin-bottom: 6px;
	            }
	            .form-select,
	            .form-control {
	                font-size: 0.5rem;
	                padding: 7px;
	                border-radius: 5px;
	                border: 1px solid #ddd;
	                width: 150%;
	            }
	            .text-center h3 {
	                font-size: 1rem;
	                font-weight: bold;
	                margin-top: 15px;
	            }
	            
	        .container {
	    font-family: 'Merriweather', serif;
	}
	
	.btn-submit {
	    background-color: #d4af37;
	    color: #ffffff;
	    padding: 10px 20px;
	    border: none;
	    border-radius: 50px;
	    font-size: 1em;
	    font-weight: bold;
	    cursor: pointer;
	    transition: all 0.3s ease;
	    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
	}
	
	.btn-submit:hover {
	    background-color: #b08a2e;
	    transform: scale(1.05);
	}
	
	
	        </style>
	       
	    
	
	        {{-- ⭐ General Experience --}}
	        <div class="form-group text-center">
	       
	                
	            </div>
	        </div>
	
	        <div class="container text-center my-5">
	    <div class="row justify-content-center">
	        @php
	            $ratingCategories = [
	               'rating' => 'Your Overall Experience', 
	                'ease_of_use' => 'Website Ease of Use',
	                'checkout_process' => 'Checkout Process',
	                'product_info' => 'Product Information',
	                'delivery_experience' => 'Delivery Experience (if applicable)',
	                'customer_support' => 'Customer Support (if applicable)',
	            ];
	        @endphp
	
	        @foreach ($ratingCategories as $name => $label)
	            <div class="col-12 mb-4">
	                <h3 class="fw-bold text-center">{{ $label }}</h3> <!-- This ensures text is centered -->
	                <div class="d-flex justify-content-center">
	                    <div class="star-container">
	                        @for ($i = 5; $i >= 1; $i--)
	                            <input type="radio" id="{{ $name }}_{{ $i }}" name="{{ $name }}" value="{{ $i }}" required>
	                            <label for="{{ $name }}_{{ $i }}">★</label>
	                        @endfor
	                    </div>
	                </div>
	            </div>
	        @endforeach
	    </div>
	</div>
	
	
	        {{-- ✅ Structured Feedback Options --}}
	        <div class="form-group">
	            <h3 class="fw-bold text-center">What did you like the most?</h3>
	            <select name="best_feature" class="form-select">
	                <option value="Product Quality">Product Quality</option>
	                <option value="Website Design">Website Design</option>
	                <option value="Checkout Process">Checkout Process</option>
	                <option value="Customer Support">Customer Support</option>
	                <option value="Delivery">Delivery</option>
	            </select>
	        </div>
	
	        <div class="form-group">
	            <h3 class="fw-bold text-center">What could be improved?</h3>
	            <select name="improvement_area" class="form-select">
	                <option value="Navigation">Navigation</option>
	                <option value="Payment Options">Payment Options</option>
	                <option value="Mobile Experience">Mobile Experience</option>
	                <option value="Shipping Time">Shipping Time</option>
	            </select>
	        </div>
	
	        {{-- ✅ Would You Recommend Us? --}}
	        <div class="form-group text-center">
	            <h3 class="fw-bold">Would you recommend us to others?</h3>
	            <div class="d-flex justify-content-center">
	                <div class="form-check mx-3">
	                    <input type="radio" id="recommend_yes" name="recommend" value="Yes" class="form-check-input" required>
	                    <label for="recommend_yes" class="form-check-label" style="font-size: 1.5rem;">Yes</label>
	                </div>
	                <div class="form-check mx-3">
	                    <input type="radio" id="recommend_no" name="recommend" value="No" class="form-check-input" required>
	                    <label for="recommend_no" class="form-check-label" style="font-size: 1.5rem;">No</label>
	                </div>
	            </div>
	        </div>
	
	        {{-- 📝 Feedback Text --}}
	        <div class="form-group">
	            <h3 class="fw-bold text-center">Additional Comments (optional):</h3>
	            <textarea name="review_text" class="form-control" style="height: 160px;" maxlength="1000"></textarea>
	        </div>
	
	        {{-- ✅ Submit Button with Loading Effect --}}
	        <div class="text-center mt-4">
	            <button type="submit" class="btn btn-warning btn-lg fw-bold px-5 py-3 btn-submit">
	                Submit Review
	            </button>
	        </div>
	    </form>
	</div>
	@endsection
