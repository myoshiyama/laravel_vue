<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Bookable;
use DateTime;

class CheckoutRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'bookings' => 'required|array|min:1',
            'bookings.*.bookable_id' => 'required|exists:bookables,id',
            'bookings.*.from' => 'required|date|after_or_equal:today',
            'bookings.*.to' => 'required|date|after_or_equal:bookings.*.from',

            'bookings.*' => ['required', function ($attribute, $value, $fail){
                $bookable = Bookable::findOrFail($value['bookable_id']);

                if (!$bookable->availableFor($value['from'], $value['to'])){
                    $fail("The object is not available in given dates!");
                }
            }]
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $bookings = $this->input('bookings');

            if ($bookings && is_array($bookings)) {
                $now = now()->toDateTimeString();

                foreach ($bookings as &$booking) {
                    $booking['created_at'] = $now;
                    $booking['updated_at'] = $now;
                }

                $this->merge(['bookings' => $bookings]);
            }
        });
    }
}
