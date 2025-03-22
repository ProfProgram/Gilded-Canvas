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
    if (!Auth::check()) {
        return redirect()->route('sign-in')->with('status', 'Please log in to [action].');
    }
}


public function store(Request $request)
{
    $request->validate([
        'rating' => 'required|integer|min:1|max:5',
        'ease_of_use' => 'required|integer|min:1|max:5',
        'checkout_process' => 'required|integer|min:1|max:5',
        'product_info' => 'required|integer|min:1|max:5',
        'delivery_experience' => 'nullable|integer|min:1|max:5',
        'customer_support' => 'nullable|integer|min:1|max:5',
        'best_feature' => 'required|string|max:255',
        'improvement_area' => 'required|string|max:255',
        'recommend' => 'required|in:Yes,No',
        'review_text' => 'nullable|string|max:1000',
    ]);

    WebsiteReview::create([
        'user_id' => Auth::id(),
        'rating' => $request->rating,
        'ease_of_use' => $request->ease_of_use,
        'checkout_process' => $request->checkout_process,
        'product_info' => $request->product_info,
        'delivery_experience' => $request->delivery_experience,
        'customer_support' => $request->customer_support,
        'best_feature' => $request->best_feature,
        'improvement_area' => $request->improvement_area,
        'recommend' => $request->recommend,
        'review_text' => $request->review_text,
    ]);
 return redirect()->back()->with('success', '✅ You successfully submitted a review!');

}

}
