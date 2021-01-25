<?php

namespace App\Http\Livewire\Backend;

use Livewire\Component;

abstract class ModelList extends Component
{
    public $model;
    public $children;
    public $created;
    public $item;

    public function mount($model)
    {
        $this->model = $model;
        $this->children = $this->getModelChildren($model) ?? [];

        $this->created = true;
        $this->resetNewItem();
    }

    public function updated($field)
    {
        $this->validateOnly($field, $this->validationRules(), [], $this->validationAttributes());
        $this->created = false;
    }

    abstract public function addItem ();

    abstract public function getModelChildren ($model);

    abstract public function getChildViewProperty ();

    abstract public function getAuthKeyProperty ();

    public function render()
    {
        return view('livewire.backend.model-list');
    }

    public function usedFields()
    {
        return ['title', 'code'];
    }

    public function resetNewItem ()
    {
        $this->item = ['title' => '','code' => ''];
    }

    public function validationAttributes ()
    {
        return [
            'item.code' => 'Code',
            'item.title' => 'Title',
        ];
    }

    public function validationRules ()
    {
        return [];
    }
}
