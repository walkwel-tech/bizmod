<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;


class DivisionUpdateRequest extends DivisionStoreRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('backend.divisions.update');
    }

    protected function ruleOverwrites()
    {
        return [
            'code' => [
                'required',
                'numeric',
                Rule::unique('divisions', 'code')->ignore($this->get('id'))
            ]
        ];
    }
}
