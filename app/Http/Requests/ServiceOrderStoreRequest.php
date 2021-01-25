<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceOrderStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('backend.order_services.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'customer_name' => [
                'required',
                'string',
            ],
            'user_id' => 'required',
            'service_id' => 'required',
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
