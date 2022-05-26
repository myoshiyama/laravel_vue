<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookableAvailabilityRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'from' => 'required|date_format:Y-m-d|after_or_equal:now',
            'to' => 'required|date_format:Y-m-d|after_or_equal:from'
        ];
    }
}
