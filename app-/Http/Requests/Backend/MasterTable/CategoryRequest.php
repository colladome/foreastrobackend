<?php

namespace App\Http\Requests\Backend\MasterTable;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
   

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:categories,name,'.$this->id,
            'image' => 'image|mimes:jpeg,jpg,png',
            'order' => 'numeric',
        ];
    }
}