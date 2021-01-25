<?php

namespace App\Http\Livewire\Backend;

use App\Rules\AlphaSpaces;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class PhaseScopes extends ModelList
{
    public function addItem ()
    {
        $this->validate($this->validationRules(), [], $this->validationAttributes());

        $newItem = $this->model->phaseScopes()->create(Arr::only($this->item, $this->usedFields()));

        $this->children->push(
            $newItem
        );

        $this->created = true;
        $this->resetNewItem();
    }

    public function getModelChildren ($model)
    {
        return $model->phaseScopes;
    }

    public function getAuthKeyProperty()
    {
        return 'phasescopes';
    }

    public function getChildViewProperty ()
    {
        return 'backend.phase-scope';
    }

    public function validationRules ()
    {
        return [
            'item.title' => [
                'required',
                new AlphaSpaces,
                Rule::unique('phase_scopes', 'title')->ignore(Arr::get($this->model, 'id'))
            ],
            'item.code' => [
                'required',
                'numeric',
                Rule::unique('phase_scopes', 'code')->ignore(Arr::get($this->model, 'id'))
            ]
        ];
    }
}
