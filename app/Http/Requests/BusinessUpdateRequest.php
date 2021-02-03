<?php

namespace App\Http\Requests;

class BusinessUpdateRequest extends BusinessStoreRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('backend.business.update');
    }

    protected function ruleOverwrites()
    {
        return [];
    }
}
