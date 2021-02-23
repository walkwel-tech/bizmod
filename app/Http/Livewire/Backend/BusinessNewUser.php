<?php

namespace App\Http\Livewire\Backend;

use App\Business;
use App\Contracts\Repository\PermissionRepositoryContract;
use App\Contracts\Repository\UserRepositoryContract;
use App\BusinessUser;
use Illuminate\Support\Arr;
use Livewire\Component;

class BusinessNewUser extends Component
{
    public $selectedRole;
    public $selectedUser;

    public $allUsers;

    public $business;

    public $roles;
    public $availableUsers;

    public $saved;

    public function mount(PermissionRepositoryContract $permissionRepo, UserRepositoryContract $userRepo, Business $business)
    {
        $this->business = $business;
        $this->allUsers = $userRepo->getUsersForSelection();

        $roles = $permissionRepo->getbusinessRoles();

        $users = ($this->allUsers->isEmpty()) ? collect() : $this->determineAvailableUsers();

        $this->roles = $roles->toArray();

        $this->availableUsers = $users->toArray();
        $this->selectedRole = $roles->first();
        $this->selectedUser = ($users->isEmpty()) ? '' : $users->first()->getKey();

        $this->saved = false;
    }

    public function updated ()
    {
        $this->validate(['selectedRole' => 'required', 'selectedUser' => 'required']);
        $this->saved = false;
    }

    public function determineAvailableUsers ()
    {
        $userIds = Arr::pluck($this->business->users, 'id');

        $finalUsers = collect($this->allUsers)->reject(function ($item) use ($userIds) {
            return in_array($item->getKey(), $userIds);
        });


        return $finalUsers;
    }


    public function save ()
    {
        $this->business->users()->attach($this->selectedUser, ['access' => $this->selectedRole]);

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
        return 'backend.business.edit';
    }

    public function render()
    {
        return view('livewire.backend.business-new-user');
    }
}
