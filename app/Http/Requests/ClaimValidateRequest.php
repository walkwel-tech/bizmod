<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClaimValidateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email',
            'phone' => 'required|numeric|unique:clients|min:9',
            'zip' => 'required|string|max:10',
            'country_name' => 'required|string',
            'country_code' => 'required|max:4',
            'page_id' => 'required|alphanum',
            'location' => 'required|string|max:150',
        ];
        return array_merge($rules, $this->ruleOverwrites());
    }

    protected function ruleOverwrites()
    {
        return [];
    }
}
