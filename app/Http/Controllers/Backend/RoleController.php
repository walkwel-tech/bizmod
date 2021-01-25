<?php

namespace App\Http\Controllers\Backend;

use App\Contracts\Repository\PermissionRepositoryContract;
use App\Http\Requests\RoleStoreRequest;
use App\Http\Requests\RoleUpdateRequest;
use Spatie\QueryBuilder\QueryBuilder;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    protected $allowedFilters = ['name'];

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $allowedFilters = $this->allowedFilters;

        $roles = QueryBuilder::for(Role::class)
            ->allowedFilters($allowedFilters)
            // ->allowedIncludes(['tags'])
            // ->allowedAppends(['status'])
            // ->withDisabled()
            ->latest()
            ->paginate();

        return view('backend.role.index', compact(['allowedFilters', 'roles']));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
    */
    public function trashed(Request $request)
    {
        $allowedFilters = $this->allowedFilters;

        $roles = QueryBuilder::for(Role::class)
            ->onlyTrashed()
            ->allowedFilters($allowedFilters)
            // ->allowedIncludes(['tags'])
            // ->allowedAppends(['status'])
            // ->withDisabled()
            ->latest()
            ->paginate();

        return view('backend.role.index', compact(['allowedFilters', 'roles']))
            ->with('pageHeader', 'Trashed');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Role $role
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Role $role)
    {
        $form = [
            'title' => 'Update',
            'action' => 'edit',
            'action_route' => route('admin.role.update', $role),
            'passwords' => true,
            'method' => 'PATCH',
        ];

        return view('backend.role.single', compact(['role', 'form']));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $role = new Role();

        $form = [
            'title' => 'Create',
            'action' => 'create',
            'passwords' => true,
            'action_route' => route('admin.role.store'),
            'method' => 'POST',
        ];

        return view('backend.role.single', compact(['role', 'form']));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Role $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Role $role)
    {
        return redirect()->route('admin.role.show', [$role]);
    }

    /**
     * @param \App\Http\Requests\RoleStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleStoreRequest $request, PermissionRepositoryContract $permissionsRepo)
    {
        $role = Role::findOrCreate($request->name);

        $permissionsAvailable = $permissionsRepo->getPermissionGroups()->flatten()->filter(function ($permission) use ($request) {
            return $request->has($permission->key);
        });

        $role->syncPermissions($permissionsAvailable);

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        return redirect()->route('admin.role.index');
    }

    /**
     * @param \App\Http\Requests\RoleUpdateRequest $request
     * @param \App\Role $role
     * @return \Illuminate\Http\Response
     */
    public function update(RoleUpdateRequest $request, PermissionRepositoryContract $permissionsRepo, Role $role)
    {
        $role->fill($request->only([
            'name',
        ]));

        $role->save();

        $permissionsAvailable = $permissionsRepo->getPermissionGroups()->flatten()->filter(function ($permission) use ($request) {
            return $request->has($permission->key);
        });

        $role->syncPermissions($permissionsAvailable);


        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        return redirect()->route('admin.role.show', [$role])
            ->with('status', __('basic.actions.modified', ['name' => $this->getModelName()]));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Role $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Role $role)
    {
        $role->delete();
        return redirect()->route('admin.role.index')->with('success', __('basic.actions.deleted', ['name' => $this->getModelName()]));
    }

    protected static function requiresPermission ()
    {
        return true;
    }

    protected static function getPermissionKey()
    {
        return 'roles';
    }

    public static function getModelName ()
    {
        return 'Role';
    }
}
