<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SlotRequest extends FormRequest
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
            'opening' => 'required',
            'closing' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'opening.required' => 'Please provide starting time for this slot.',
            'closing.required' => 'Please provide ending time for this slot.',
        ];
    }
}
