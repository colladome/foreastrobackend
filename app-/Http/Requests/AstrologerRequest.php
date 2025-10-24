<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AstrologerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [

            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:astrologers,email',
            'mobile_number' => 'required|unique:astrologers,mobile_number',
            'gender' => 'required',
        ];
    }
}
