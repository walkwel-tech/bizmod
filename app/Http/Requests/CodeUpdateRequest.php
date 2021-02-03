<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class CodeUpdateRequest extends CodeStoreRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('backend.codes.update');
    }


}
