<?php

namespace App\Http\Livewire\Backend;

use App\Phase;
use App\Rules\AlphaSpaces;
use Illuminate\Validation\Rule;
use Illuminate\Support\Arr;

class DivisionPhase extends ChildItem
{
    public function getShowRouteProperty()
    {
        return 'admin.phase.show';
    }

    public function getModel ()
    {
        return Phase::where('id', $this->model['id'])->withTrashed()->first();
    }

    public function getTitle ()
    {
        return "\"{$this->model['title']}\"";
    }

    public function usedFields()
    {
        return ['title', 'code'];
    }

    public function validationRules ()
    {
        return [
            'model.title' => [
                'required',
                new AlphaSpaces,
                Rule::unique('phases', 'title')->ignore(Arr::get($this->model, 'id'))
            ],
            'model.code' => [
                'required',
                'numeric',
                Rule::unique('phases', 'code')->ignore(Arr::get($this->model, 'id'))
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
        return 'phases';
    }

    public function getItemNameProperty()
    {
        return 'Phase';
    }
}
