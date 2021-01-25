<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends UserStoreRequest
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
     * Get the additional Validation rules or overwrite defaults
     *
     * @return array
     */
    protected function additionalRules()
    {
        return [
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($this->id),
            ],
            'password' => 'nullable|min:8|max:50|confirmed',
        ];
    }
}
