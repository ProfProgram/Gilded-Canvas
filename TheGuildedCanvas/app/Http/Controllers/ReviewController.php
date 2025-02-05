<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;
use App\Models\Product;

class ReviewController extends Controller
{
    public function index()
    {
        // $db_product = DB::table('Products Table');
        // $prod_names = $db_product->select('Product_id','Product_name')->get();
        $prod_names = Product::all(['product_id', 'product_name']);
        return view('review', ['prod_names'=>$prod_names]);
    }

    public function store(Request $request)
    {
        // $review = new Review;
        // $db_product = DB::table('Products Table');
        // $prod_id = $db_product->where('Product_name', $request->input('Product_name'))->select('Product_id');

        // $review->User_id = $request->input('User_id');

        // // $review->Product_id = $request->input('Product_name');
        // // require product_id as that is products f-key in review db
        // $review->Product_id = $db_product->where('Product_name', $request->input('Product_name'))->value('Product_id');

        // $review->Rating = $request->input('Rating');
        // $review->Review_text = $request->input('Review_text');

        // $review->save();

        Auth::check() ? Auth::user()->name :'';
        $request->validate([
            'User_id' => 'required|integer',
            'Product_id' => 'required|integer',
            'Rating' => 'required|integer|min:1|max:5',
            'Review_text' => 'required|string',
        ]);

        $review = new Review;
        
        $review->user_id = $request->User_id;
        $review->product_id = $request->Product_id;
        $review->rating = $request->Rating;
        $review->review_text = $request->Review_text;

        try {
            if ($review->save()) {
                $status = 'Review Added Successfully';
            } else {
                $status = 'Review was not added';
            }
        } catch (\Exception $e) {
            Log::error('Failed to save review: ' . $e->getMessage());
            $status = 'An error occurred while saving the review.';
        }

        Log::info('Form data received: ', $request->all());


        return redirect()->back()->with('status', $status);
    }
}
