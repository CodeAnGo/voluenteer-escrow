<?php

namespace App\Http\Requests;

use App\Models\Transfer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class TransferUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $transfer = Transfer::find($this->route('transfer'));
        return isset($transfer);
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
            'delivery_phone' => 'required|numeric|digits_between:8,20',
            'transfer_reason' => 'required|max:255',
            'transfer_amount' => 'required|numeric|between:0.01,9999.99',
            'delivery_street_1' => 'required|max:255',
            'delivery_street_2' => 'max:255',
            'delivery_city' => 'required|max:255|alpha',
            'delivery_county' => 'max:30',
            'delivery_country' => 'required',
            'transfer_note' => 'required|max:255|alpha_dash'
        ];
    }
}
