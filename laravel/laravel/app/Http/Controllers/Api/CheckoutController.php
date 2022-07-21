<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use Illuminate\Http\Request;
use App\Bookable;
use App\Booking;

class CheckoutController extends Controller
{
    public function __invoke(CheckoutRequest $request)
    {
        $data = $request->all();

        $data = array_merge($data, $request->all());

        $bookingsData = $data['bookings'];

        $bookings = collect($bookingsData)->map(function ($bookingData) {
            $bookable = Bookable::findOrFail($bookingData['bookable_id']);
            $booking = new Booking();
            $booking->from = $bookingData['from'];
            $booking->to = $bookingData['to'];
            $booking->price = $bookable->priceFor($booking->from, $booking->to)['total'];
            $booking->bookable() -> associate($bookable);

            return $booking;
        });

        Booking::insert($bookings);
    }
}
