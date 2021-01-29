<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('backend.clients.create');
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
            'email' => 'required|email|unique:users',
            'phone' => 'required|numeric|min:9',
            'zip' => 'required|string|max:10',
        ];
        return array_merge($rules, $this->ruleOverwrites());
    }

    protected function ruleOverwrites()
    {
        return [];
    }
}
