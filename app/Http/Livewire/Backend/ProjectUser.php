<?php

namespace App\Http\Livewire\Backend;

use App\Contracts\Repository\PermissionRepositoryContract;
use App\User;
use Livewire\Component;

class ProjectUser extends Component
{
    public $roles;
    public $user;
    public $selectedRole;
    public $saved;
    public $deleted;

    public $project;

    public function updated()
    {
        $this->saved = false;
        $this->deleted = false;
    }

    public function mount(PermissionRepositoryContract $permissionRepo, User $user)
    {
        $this->roles = $permissionRepo->getProjectRoles()->toArray();
        $this->user = $user;
        $this->project = $user->role->project_id;
        $this->selectedRole = $user->role->role;

        $this->saved = true;
    }

    public function render()
    {
        return view('livewire.backend.project-user');
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

        $this->user->projects()->updateExistingPivot($this->project, ['role' => $this->selectedRole]);

        $this->emit('notifyUser', ['message' => __('basic.actions.saved', ['name' => "Relation with {$this->user->name}"]), 'type' => 'primary']);
    }

    public function deleteRelation ()
    {
        $this->deleted = $this->user->projects()->detach($this->project);
        $this->emit('notifyUser', ['message' => __('basic.actions.removed', ['name' => "Relation with {$this->user->name}"]), 'type' => 'danger']);

        $this->emit('reload');
    }
}
