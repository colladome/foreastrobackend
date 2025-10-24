<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewManagementController extends Controller
{
    public function index()
    {
        $reviews = Review::orderBy('id', 'desc')->with('astrologer', 'user')->get();

        return view('backend.review.index', compact('reviews'));
    }


    public function approve($id)
    {
        $review = Review::findOrFail($id);
        $review->status = '1';
        $review->save();
        return back()->with('success', 'Review Approved Successfully!');
    }

    public function reject($id)
    {
        $review = Review::findOrFail($id);
        $review->status = '0';
        $review->save();
        return back()->with('success', 'Review Reject Successfully!');
    }

    public function delete($id)
    {
     
        $review = Review::findOrFail($id);
        
        
        $review->delete();
        return back()->with('success', 'Review Delete Successfully!');
    }
}
