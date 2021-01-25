<?php

namespace App\Http\Requests;

use App\Step;
use App\Rules\AlphaSpaces;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StepStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('backend.steps.create');
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
            'description' => 'required',
            'content' => 'required',
        ];
        return array_merge($rules, $this->ruleOverwrites());
    }
    protected function ruleOverwrites()
    {
        return [];
    }
}
