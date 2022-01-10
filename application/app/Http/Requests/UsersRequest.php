<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsersRequest extends FormRequest
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
            'first_name' => 'required|string|max:191',
            'last_name' => 'required|string|max:191',
            'phone_number' => 'required|unique:users|max:15',
            'email' => 'required|string|email|max:191|unique:users',
            'password' => 'required|string|min:6',
            'is_active' => 'required',
            'role_id' => 'required|not_in:0',
            'photo_id' => 'mimes:jpeg,png'
        ];
    }
}