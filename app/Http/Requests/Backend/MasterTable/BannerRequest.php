<?php

namespace App\Http\Requests\Backend\MasterTable;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
{
   

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'banner' => 'required|image|mimes:jpeg,jpg,png',
        ];
    }
}