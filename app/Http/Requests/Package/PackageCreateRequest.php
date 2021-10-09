<?php

namespace App\Http\Requests\Package;

use Illuminate\Foundation\Http\FormRequest;


class PackageCreateRequest extends FormRequest
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
            'category_id' => 'required',
            'user_id' => 'required',
            'name' => 'required',
            'desc' => 'required',
            'price' => 'required',
            // 'default_img' => 'required'
            // 'is_active' => 'required'
        ];
    }

}
