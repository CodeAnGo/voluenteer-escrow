<?php

namespace App\Http\Requests;

use App\Models\Address;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserAddressUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $address = Address::find($this->route('address'));
        return $address && $address->user_id === Auth::id();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|between:1,255',
            'email' => 'required|between:1,255|email',
            'line1' => 'required|between:1,255',
            'line2' => 'max:255',
            'city' => 'required|between:1,255',
            'county' => 'max:255',
            'postcode' => 'required|between:1,255',
            'country' => 'required|between:1,255',
        ];
    }
}
