<?php


namespace App\Http\Requests;

use App\Field;
use App\Rules\AlphaSpaces;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FeildStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('backend.fields.create');
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
            'name' => [
                'required',
                'string',
            ],

            'type' => [
                'required',
                'string',
            ],
        ];
        return array_merge($rules, $this->ruleOverwrites());
    }
    protected function ruleOverwrites()
    {
        return [];
    }
}
