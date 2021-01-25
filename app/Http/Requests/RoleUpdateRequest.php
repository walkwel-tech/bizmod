<?php

namespace App\Http\Requests;

class RoleUpdateRequest extends RoleStoreRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('backend.roles.update');
    }
}
