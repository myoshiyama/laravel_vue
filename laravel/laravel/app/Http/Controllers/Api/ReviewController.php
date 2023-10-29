<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReviewResource;
use App\Review;
use App\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    public function show($id)
    {
        return new ReviewResource(Review::findOrFail($id));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
    
            $booking = Booking::findByReviewKey($data['id']);
    
            if(null === $booking){
                return abort(404);
            }
    
            $booking->review_key = '';
            $booking->save();
    
            $review = Review::make($data);
            $review->booking_id = $booking->id;
            $review->bookable_id = $booking->bookable_id;
            $review->save();

            DB::commit();

            return new ReviewResource($review);
        } catch (Exception $e) {
            DB::rollBack();
        }
    }
}
