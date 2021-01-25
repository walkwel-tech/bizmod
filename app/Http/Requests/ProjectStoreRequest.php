<?php

namespace App\Http\Requests;

use App\Project;
use App\Rules\AlphaSpaces;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjectStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('backend.projects.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'title' => [
                'required',
                'string',
            ],
            'status' => [
                'required',
                Rule::in(Project::getAvailableStatusValues())
            ],
            'bid_at' => [
                'required',
                'date_format:Y-m-d',
                'after_or_equal:today',
            ],
            'start_at' => [
                'required',
                'date_format:Y-m-d',
                'after:bid_at',
            ],
            'end_at' => [
                'required',
                'date_format:Y-m-d',
                'after:start_at',
            ],
        ];
        return array_merge($rules, $this->ruleOverwrites());
    }

    protected function ruleOverwrites()
    {
        return [];
    }
}
