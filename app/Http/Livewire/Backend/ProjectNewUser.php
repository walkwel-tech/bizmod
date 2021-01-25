<?php

namespace App\Http\Livewire\Backend;

use App\Contracts\Repository\PermissionRepositoryContract;
use App\Contracts\Repository\UserRepositoryContract;
use App\Project;
use Illuminate\Support\Arr;
use Livewire\Component;

class ProjectNewUser extends Component
{
    public $selectedRole;
    public $selectedUser;

    public $allUsers;

    public $project;

    public $roles;
    public $availableUsers;

    public $saved;

    public function mount(PermissionRepositoryContract $permissionRepo, UserRepositoryContract $userRepo, Project $project)
    {
        $this->roles = $permissionRepo->getProjectRoles()->toArray();

        $this->project = $project;

        $this->allUsers = $userRepo->getUsersForSelection();

        $this->availableUsers = $this->determineAvailableUsers();


        $this->saved = true;
    }

    public function updated ()
    {
        $this->validate(['selectedRole' => 'required', 'selectedUser' => 'required']);
        $this->saved = false;
    }

    public function determineAvailableUsers ()
    {
        $userIds = Arr::pluck($this->project->users, 'id');

        $finalUsers = collect($this->allUsers)->reject(function ($item) use ($userIds) {
            return in_array($item['id'], $userIds);
        })->toArray();

        return $finalUsers;
    }


    public function save ()
    {
        $this->project->users()->attach($this->selectedUser, ['role' => $this->selectedRole]);

        $this->selectedUser = '';
        $this->selectedRole = '';

        $this->emit('notifyUser', ['message' => __('basic.actions.saved', ['name' => "Relation"]), 'type' => 'primary']);
        $this->emit('reload');
    }

    public function getItemNameProperty ()
    {
        return 'User';
    }

    public function getAuthKeyProperty ()
    {
        return 'backend.projects.edit';
    }

    public function render()
    {
        return view('livewire.backend.project-new-user');
    }
}
