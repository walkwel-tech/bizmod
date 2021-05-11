<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('backend.import.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
           // 'import_file' => 'required|max:10000000|mimes:application/vnd.ms-excel',
        ];
        return array_merge($rules, $this->ruleOverwrites());
    }

    protected function ruleOverwrites()
    {
        return [];
    }
}
