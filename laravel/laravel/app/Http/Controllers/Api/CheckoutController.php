<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Bookable;
use App\Booking;

class CheckoutController extends Controller
{
    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'bookings' => 'required|array|min:1',
            'bookings.*.bookable_id' => 'required|exists:bookables,id',
            'bookings.*.from' => 'required|date|after_or_equal:today',
            'bookings.*.to' => 'required|date|after_or_equal:bookings.*.from',
        ]);
        $data = array_merge($data, $request->validate([
            'bookings.*' => ['required', function ($attribute, $value, $fail){
                $bookable = Bookable::findOrFail($value['bookable_id']);

                if (!$bookable->availableFor($value['from'], $value['to'])){
                    $fail("The object is not available in given dates!");
                }
            }]
        ]));

        $bookingsData = $data['bookings'];

        $bookings = collect($bookingsData)->map(function ($bookingData) {
            $bookable = Bookable::findOrFail($bookingData['bookable_id']);
            $booking = new Booking();
            $booking->from = $bookingData['from'];
            $booking->to = $bookingData['to'];
            $booking->price = $bookable->priceFor($booking->from, $booking->to)['total'];
            $booking->bookable() = associate($bookable);

            $booking->save();

            return $booking;
        });

        return $bookings;
    }
}
