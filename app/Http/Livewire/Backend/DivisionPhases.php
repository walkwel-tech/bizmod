<?php

namespace App\Http\Livewire\Backend;

use App\Rules\AlphaSpaces;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class DivisionPhases extends ModelList
{
    public function addItem ()
    {
        $this->validate($this->validationRules(), [], $this->validationAttributes());

        $newItem = $this->model->phases()->create(Arr::only($this->item, $this->usedFields()));

        $this->children->push(
            $newItem
        );

        $this->created = true;
        $this->resetNewItem();
    }

    public function getModelChildren ($model)
    {
        return $model->phases;
    }

    public function getAuthKeyProperty()
    {
        return 'phases';
    }

    public function getChildViewProperty ()
    {
        return 'backend.division-phase';
    }

    public function validationRules ()
    {
        return [
            'item.title' => [
                'required',
                new AlphaSpaces,
                Rule::unique('phases', 'title')->ignore(Arr::get($this->model, 'id'))
            ],
            'item.code' => [
                'required',
                'numeric',
                Rule::unique('phases', 'code')->ignore(Arr::get($this->model, 'id'))
            ]
        ];
    }
}
