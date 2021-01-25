<?php

namespace App\View\Components;

use App\Contracts\Repository\PermissionRepositoryContract;
use Illuminate\View\Component;

class RolesSelector extends Component
{
    public $roles;

    public $model;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(PermissionRepositoryContract $permissionsRepo, $model)
    {
        $this->roles = $permissionsRepo->getRoles();
        $this->model = $model;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.roles-selector');
    }
}
