<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class ProfileRequest extends UserUpdateRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
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
                Rule::unique('users')->ignore(auth()->id()),
            ],
        ];
    }
}
