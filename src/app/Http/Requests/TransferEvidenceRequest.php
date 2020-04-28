<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferEvidenceRequest extends FormRequest
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
            'evidence' => 'required',
            'evidence.*' => 'image|max:2048|mimes:jpeg,png,jpg',
            'actual_amount' => 'required|numeric|min:0',
            'transfer_note' => 'alpha_dash|max:255|nullable'
        ];
    }

}
