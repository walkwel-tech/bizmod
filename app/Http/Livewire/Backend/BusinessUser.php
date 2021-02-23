<?php

namespace App\Http\Livewire\Backend;

use App\Business;
use App\Contracts\Repository\PermissionRepositoryContract;
use App\User;
use Livewire\Component;

class BusinessUser extends Component
{
    public $roles;
    public $user;
    public $selectedRole;
    public $saved;
    public $deleted;

    public $business;

    public function updated()
    {
        $this->saved = false;
        $this->deleted = false;
    }

    public function mount(PermissionRepositoryContract $permissionRepo, User $user, Business $business)
    {
        $this->roles = $permissionRepo->getBusinessRoles()->toArray();
        $this->user = $user;
        $this->business = $business;
        $this->selectedRole = $user->role->access;

        $this->saved = true;
    }

    public function render()
    {
        return view('livewire.backend.business-user');
    }

    public function getItemNameProperty ()
    {
        return 'User';
    }

    public function getAuthKeyProperty()
    {
        return 'users';
    }

    public function save ()
    {
        $this->saved = true;

        $this->user->business()->updateExistingPivot($this->business, ['access' => $this->selectedRole]);

        $this->emit('notifyUser', ['message' => __('basic.actions.saved', ['name' => "Relation with {$this->user->name}"]), 'type' => 'primary']);
    }

    public function deleteRelation ()
    {
        $this->deleted = $this->user->Business()->detach($this->business);
        $this->emit('notifyUser', ['message' => __('basic.actions.removed', ['name' => "Relation with {$this->user->name}"]), 'type' => 'danger']);

        $this->emit('reload');
    }
}
