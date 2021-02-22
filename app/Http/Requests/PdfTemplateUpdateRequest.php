<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PdfTemplateUpdateRequest extends PdfTemplateStoreRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('backend.pdf_templates.update');
    }

    protected function ruleOverwrites()
    {
        return [
            'path' => 'sometimes|max:10000|mimes:pdf',
        ];
    }
}
