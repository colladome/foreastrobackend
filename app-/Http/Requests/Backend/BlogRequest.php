<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 'category' => 'required',
            'title' => 'required',
            'image' => 'required|image|mimes:jpeg,jpg,png',
            'description' => 'required',
        ];
    }
}
