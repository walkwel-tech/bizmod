<?php

namespace App\Http\Livewire\Backend;

use App\Contracts\Repository\PermissionRepositoryContract;
use App\Contracts\Repository\UserRepositoryContract;
use App\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Livewire\Component;

class ProjectUsers extends Component
{

    public $project;
    public $users;

    public function mount(PermissionRepositoryContract $permissionsRepo, $project)
    {
        $this->roles = $permissionsRepo->getProjectRoles()->toArray();

        $this->project = $project;
        $this->users = $project->users;
    }

    public function getAuthKeyProperty ()
    {
        return 'backend.projects.edit';
    }

}
