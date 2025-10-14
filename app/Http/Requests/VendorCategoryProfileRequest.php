<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VendorCategoryProfileRequest extends FormRequest
{
   

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'business_profile_name' => 'required',
            'contact_number' => 'required|numeric|min:10',
            'state' => 'required',
            'city' => 'required',
            'area' => 'required',
            'address' => 'required',
            'pin_code' => 'required|numeric',
            'listing_cover_image' => 'image|mimes:jpeg,jpg,png',
        ];
    }
}