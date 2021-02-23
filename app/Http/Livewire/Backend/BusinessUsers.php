<?php

namespace App\Http\Livewire\Backend;

use App\Business;
use App\Contracts\Repository\PermissionRepositoryContract;
use App\User;
use Livewire\Component;

class BusinessUsers extends Component
{

    public $business;
    public $users;

    public function mount(PermissionRepositoryContract $permissionsRepo, Business $business)
    {
        $this->roles = $permissionsRepo->getBusinessRoles()->toArray();

        $this->business = $business;
        $this->users = $business->users->reject(function ($user) use ($business) {
            return $user->id === $business->owner_id;
        });
    }

    public function getAuthKeyProperty ()
    {
        return 'backend.business.edit';
    }

}
