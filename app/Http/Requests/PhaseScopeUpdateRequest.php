<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;


class PhaseScopeUpdateRequest extends PhaseScopeStoreRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('backend.phases.update');
    }

    protected function ruleOverwrites()
    {
        return [
            'code' => [
                'required',
                'numeric',
                Rule::unique('phase_scopes', 'code')->ignore($this->get('id'))
            ]
        ];
    }
}
