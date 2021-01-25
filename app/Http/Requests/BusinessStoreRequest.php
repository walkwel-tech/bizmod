<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BusinessStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('backend.business.create');
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
            'prefix' => 'required|max:3',
        ];
        return array_merge($rules, $this->ruleOverwrites());
    }

    protected function ruleOverwrites()
    {
        return [];
    }

}
