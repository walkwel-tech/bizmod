<?php

namespace App\Http\Livewire\Backend;

use App\PhaseScope as Scope;
use App\Rules\AlphaSpaces;
use Illuminate\Validation\Rule;
use Illuminate\Support\Arr;

class PhaseScope extends ChildItem
{
    public function getShowRouteProperty()
    {
        return 'admin.scope.show';
    }

    public function getModel ()
    {
        return Scope::where('id', $this->model['id'])->withTrashed()->first();
    }

    public function usedFields()
    {
        return ['title', 'code'];
    }

    public function getTitle ()
    {
        return "\"{$this->model['title']}\"";
    }

    public function validationRules ()
    {
        return [
            'model.title' => [
                'required',
                new AlphaSpaces,
                Rule::unique('phase_scopes', 'title')->ignore(Arr::get($this->model, 'id'))
            ],
            'model.code' => [
                'required',
                'numeric',
                Rule::unique('phase_scopes', 'code')->ignore(Arr::get($this->model, 'id'))
            ]
        ];
    }

    public function validationAttributes ()
    {
        return [
            'model.code' => 'Code',
            'model.title' => 'Title',
        ];
    }

    public function targetFields ()
    {
        return ['title', 'code', 'id', 'slug', 'deleted_at'];
    }

    public function getAuthKeyProperty()
    {
        return 'phasescopes';
    }

    public function getItemNameProperty()
    {
        return 'Scope';
    }

}
