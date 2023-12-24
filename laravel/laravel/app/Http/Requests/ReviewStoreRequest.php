<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|max:36',
            // 'id' => 'required|max:36|unique:bookings,review_key',
            'content' => 'required|min:2',
            'rating' => 'required|in:1,2,3,4,5',
        ];
    }
}
