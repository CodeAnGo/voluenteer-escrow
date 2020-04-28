<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferDisputeRequest extends FormRequest
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
            'dispute_reason' => 'required|alpha_dash|between:1,255',
            'evidence.*' => 'image|max:2048|mimes:jpeg,png,jpg',
        ];
    }
}
