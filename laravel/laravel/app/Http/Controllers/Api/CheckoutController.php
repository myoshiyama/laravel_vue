<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use Illuminate\Http\Request;
use App\Bookable;
use App\Booking;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function __invoke(CheckoutRequest $request)
    {
        $data = $request->all();

        $bookingsData = $data['bookings'];

        $bookings = collect($bookingsData)->map(function ($bookingData) {
            $bookable = Bookable::findOrFail($bookingData['bookable_id']);
            $booking = new Booking();
            $booking->from = $bookingData['from'];
            $booking->to = $bookingData['to'];
            $booking->price = $bookable->priceFor($booking->from, $booking->to)['total'];
            $booking->bookable_id = $bookingData['bookable_id'];
            $booking->review_key = Str::uuid();

            return $booking;
        });

        DB::beginTransaction();

        try {
            Booking::insert($bookings->toArray());

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

        return $bookings;
    }
}
