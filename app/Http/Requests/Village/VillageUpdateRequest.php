<?php

namespace App\Http\Requests\Village;

use Illuminate\Foundation\Http\FormRequest;


class VillageUpdateRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'sometimes|confirmed',
            'password_confirmation' => 'sometimes|same:password',
            'phone' => 'required',
            'village_name' => 'required',
            'village_address' => 'required',
            'contact_person' => 'required',
            'desc' => 'required',
            'bank_name' => 'required',
            'bank_acc_name' => 'required',
            'bank_acc_no' => 'required'
        ];
    }

}
