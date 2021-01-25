<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;


class ProjectUpdateRequest extends ProjectStoreRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('backend.projects.update');
    }


    protected function ruleOverwrites()
    {
        return [
            'bid_at' => [
                'required',
                'date_format:Y-m-d',
            ],
        ];
    }
}
