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
            'delivery_first_name' => 'required|alpha|max:255',
            'delivery_last_name' => 'required|alpha_dash|max:255',
            'delivery_email' => 'required|max:255|email',
            'delivery_phone' => 'required|numeric|digits_between:1,20',
            'transfer_reason' => 'required|max:255',
            'transfer_amount' => 'required|numeric|between:0.01,9999.99',
            'transfer_note' => 'required|max:255|alpha_dash',
            'images.*' => 'sometimes|image|max:2048|mimes:jpeg,png,jpg',
            'user_address_select' => 'required'
        ];
    }
}
