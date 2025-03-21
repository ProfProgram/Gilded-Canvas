<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WebsiteReview;
use Illuminate\Support\Facades\Auth;

class WebsiteReviewController extends Controller
{
   public function create()
{
    return view('create'); // Laravel will now find it inside resources/views/
}


    // Store review in database
    public function store(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review_text' => 'nullable|string|max:1000',
        ]);

        WebsiteReview::create([
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'review_text' => $request->review_text,
        ]);

        return redirect()->route('home')->with('success', 'Thank you for your feedback!');
    }

    // Display all website reviews
    public function index()
    {
        $reviews = WebsiteReview::latest()->paginate(10);
        return view('website_reviews.index', compact('reviews'));
    }
}
