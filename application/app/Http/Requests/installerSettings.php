<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class installerSettings extends FormRequest
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
            'business_name' => 'required|string|max:191',
            'default_currency' => 'required|not_in:0',
            'lang' => 'required|not_in:0',
            'contact_email' => 'required|email|max:191',
            'contact_number' => 'required|max:15',
            'first_name' => 'required|string|max:191',
            'last_name' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'password' => 'required|string|min:6|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'lang.required' => 'Please select your language.'
        ];
    }
}
