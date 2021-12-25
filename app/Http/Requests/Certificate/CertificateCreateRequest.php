<?php

namespace App\Http\Requests\Certificate;

use Illuminate\Foundation\Http\FormRequest;

class CertificateCreateRequest extends FormRequest
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
            'category' => 'required',

            'reference_number' => 'required',
            'date_at' => 'required',
            'regarding' => 'required',
            'signer' => 'required',
            'addressed_to'=> 'required',
            'departemen' => 'required',
            'isActive' => 'required',
            'file' => 'required'



    ];
    }
}
