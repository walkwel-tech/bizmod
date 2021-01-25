<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
        return array_merge([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email|unique:users',
        ], $this->additionalRules());
    }

    /**
     * Get the additional Validation rules or overwrite defaults
     *
     * @return array
     */
    protected function additionalRules()
    {
        return [
            'password' => 'required|min:8|max:50|confirmed'
        ];
    }
}
