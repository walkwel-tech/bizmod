<?php

namespace App\Http\Livewire\Backend;

use Illuminate\Support\Arr;
use Livewire\Component;

abstract class ChildItem extends Component
{
    public $model;
    public $saved;
    public $trashed;

    public function mount($model)
    {
        $this->model = $model->only($this->targetFields());
        $this->saved = true;
        $this->trashed = $model->trashed();
    }

    public function render()
    {
        return view('livewire.backend.child-item');
    }

    public function updated($field)
    {
        $this->validateOnly($field, $this->validationRules(), [], $this->validationAttributes());
        $this->saved = false;
    }

    public function save ()
    {
        $this->validate($this->validationRules(), [], $this->validationAttributes());

        $model = $this->getModel();
        $model->fill(Arr::only($this->model, $this->usedFields()));

        $model->save();
        $this->saved = true;

        $this->model = $model->only($this->targetFields());

        $this->emit('notifyUser', ['message' => __('basic.actions.saved', ['name' => $this->getTitle()]), 'type' => 'primary']);
    }

    public function toggleTrash()
    {
        $model = $this->getModel();

        if ($model->trashed()) {
            $model->restore();
            $this->trashed = false;

            $this->emit('notifyUser', ['message' => __('basic.actions.restored', ['name' => $this->getTitle()]), 'type' => 'info']);
        } else {
            $model->delete();
            $this->trashed = true;

            $this->emit('notifyUser', ['message' => __('basic.actions.trashed', ['name' => $this->getTitle()]), 'type' => 'danger']);
        }
    }

    public function getItemNameProperty()
    {
        return 'Item';
    }

    abstract public function getTitle();

    abstract public function getAuthKeyProperty ();

    abstract public function getShowRouteProperty();

    abstract public function getModel ();

    abstract public function usedFields();

    abstract public function validationRules ();

    abstract public function validationAttributes ();

    abstract public function targetFields ();
}
