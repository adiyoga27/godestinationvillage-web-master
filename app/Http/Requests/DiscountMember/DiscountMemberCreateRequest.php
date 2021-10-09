<?php

namespace App\Http\Requests\DiscountMember;

use Illuminate\Foundation\Http\FormRequest;


class DiscountMemberCreateRequest extends FormRequest
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
            'type' => 'required',
            'value' => 'required',
            // 'is_active' => 'required'
        ];
    }

}
