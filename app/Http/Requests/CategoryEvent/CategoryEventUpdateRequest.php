<?php

namespace App\Http\Requests\CategoryEvent;

use Illuminate\Foundation\Http\FormRequest;

class CategoryEventUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (auth()->user()) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'description' => 'nullable',
            'is_active' => 'required',


            // 'is_active' => 'required'
        ];
    }
}
