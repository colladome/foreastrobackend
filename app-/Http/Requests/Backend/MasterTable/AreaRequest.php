<?php

namespace App\Http\Requests\Backend\MasterTable;

use Illuminate\Foundation\Http\FormRequest;

class AreaRequest extends FormRequest
{
   

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'state' => 'required',
            'city' => 'required',
            'name' => 'required',
        ];
    }
}