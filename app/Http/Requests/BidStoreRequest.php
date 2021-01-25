<?php

namespace App\Http\Requests;

use App\Bid;
use App\Rules\AlphaSpaces;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BidStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('backend.bids.create');
    }

    public function getValidatorInstance()
    {
        $this->cleanLockedInput();
        return parent::getValidatorInstance();
    }

    public function cleanLockedInput()
    {
        $this->merge([
            'locked' => $this->request->has('locked') ? 1 : 0
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'basic' => 'required|numeric|min:0',
            'bond_limit' => 'required|numeric|min:0',
            'bond_rate' => 'required|numeric|min:0',
            'bond_cost' => 'required|numeric|min:0',
            'profit' => 'required|numeric|min:0',
            'liability' => 'required|numeric|min:0',
            'risk' => 'required|numeric|min:0',
            'locked' => 'required|boolean',
            'status' => [
                'required',
                Rule::in(Bid::getAvailableStatusValues())
            ],
        ];
        return array_merge($rules, $this->ruleOverwrites());
    }

    protected function ruleOverwrites()
    {
        return [];
    }
}
