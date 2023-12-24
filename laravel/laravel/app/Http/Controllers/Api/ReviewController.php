<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReviewResource;
use App\Http\Requests\ReviewStoreRequest;
use App\Review;
use App\Booking;
use Illuminate\Support\Facades\DB;
use Exception;

class ReviewController extends Controller
{
    public function show($id)
    {
        return new ReviewResource(Review::findOrFail($id));
    }

    public function store(ReviewStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();

            if (!isset($data['id'])) {
                abort(404, 'Review key not provided');
            }

            $booking = Booking::findByReviewKey($data['id']);

            if (null === $booking) {
                abort(404, 'Booking not found');
            }

            $booking->review_key = '';
            $booking->save();

            $review = Review::make($data);
            $review->booking_id = $booking->id;
            $review->bookable_id = $booking->bookable_id;
            $review->save();

            DB::commit();

            return (new ReviewResource($review))->response()->setStatusCode(201);
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
