<?php

namespace App\Http\Requests;

use App\Service;
use App\Rules\AlphaSpaces;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ServiceStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('backend.services.create');
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
            'amount' => "required|regex:/^\d+(\.\d{1,2})?$/"
        ];
        return array_merge($rules, $this->ruleOverwrites());
    }
    protected function ruleOverwrites()
    {
        return [];
    }
}
