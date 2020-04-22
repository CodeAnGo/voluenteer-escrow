<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'delivery_first_name' => 'required|max:255',
            'delivery_last_name' => 'required|max:255',
            'delivery_email' => 'required|max:255|email',
            'delivery_phone' => 'required|digits_between:1,20',
            'transfer_reason' => 'required|max:255',
            'transfer_amount' => 'required|between:0.01,9999.99',
        ];
    }
}
