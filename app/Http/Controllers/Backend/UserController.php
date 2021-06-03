<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\ImageController;
use App\User;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use Spatie\QueryBuilder\QueryBuilder;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $allowedFilters = $this->getAllowedFilters();

        $users = QueryBuilder::for(User::class)
            ->allowedFilters(array_keys($allowedFilters))
            // ->allowedIncludes(['tags'])
            // ->allowedAppends(['status'])
            // ->withDisabled()
            ->latest()
            ->paginate();

        $authKey = $this->getPermissionKey();
        $addNew = auth()->user()->can("backend.{$authKey}.create");

        $searchedParams = $request->input('filter');

        Session::put('user.filters', $searchedParams);

        return view('backend.user.index', compact(['allowedFilters', 'searchedParams',  'users', 'addNew']));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function trashed(Request $request)
    {
        $allowedFilters = $this->allowedFilters;

        $users = QueryBuilder::for(User::class)
            ->onlyTrashed()
            ->allowedFilters($allowedFilters)
            // ->allowedIncludes(['tags'])
            // ->allowedAppends(['status'])
            // ->withDisabled()
            ->latest()
            ->paginate();

        $authKey = $this->getPermissionKey();
        $addNew = false; // auth()->user()->can("backend.{$authKey}.create");

        return view('backend.user.index', compact(['allowedFilters', 'users', 'addNew']))
            ->with('pageHeader', 'Trashed');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, User $user)
    {
        $form = [
            'title' => 'Update',
            'action' => 'edit',
            'action_route' => route('admin.user.update', $user),
            'passwords' => true,
            'method' => 'PATCH',
        ];

        $backURL = route('admin.user.index', ['filter' => Session::get('user.filters', [])]);

        return view('backend.user.single', compact(['user', 'form', 'backURL']));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = new User();

        $form = [
            'title' => 'Create',
            'action' => 'create',
            'passwords' => true,
            'action_route' => route('admin.user.store'),
            'method' => 'POST',
        ];

        return view('backend.user.single', compact(['user', 'form']));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, User $user)
    {
        return redirect()->route('admin.user.show', [$user]);
    }

    /**
     * @param \App\Http\Requests\UserStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $user = User::make($request->only([
            'first_name',
            'last_name',
            'middle_name',
            'email',
            'country',
            'state',
            'city',
            'zip',
            'phone'
        ]));

        $user->password = Hash::make($request->password);
        $user->email_verified_at = now();

        if ($request->hasFile('avatar')) {
            $imageController = new ImageController();

            $fileName     =
                $imageController->saveFile(
                    $request,
                    null,
                    'image',
                    'avatars'
                );
            $user->avatar = $fileName;
        }

        if ($request->has('email_verified')) {
            $user->markEmailAsVerified();
        }

        if ($request->has('roles')) {
            $user->syncRoles($request->roles);
        }

        $user->save();

        $user->syncAddresses($request->input('address'), $request->input('country'), $request->input('state'), $request->input('city'));

        // Mail::to($user->owner)->send(new TaskAssignmentNotification($user));

        return redirect()->route('admin.user.index');
    }

    /**
     * @param \App\Http\Requests\UserUpdateRequest $request
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $user->fill($request->only([
            'first_name',
            'last_name',
            'middle_name',
            'email',
            'country',
            'state',
            'city',
            'zip',
            'phone'
        ]));

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        if ($request->has('email_verified')) {
            $user->markEmailAsVerified();
        }

        if ($request->has('roles')) {
            $user->syncRoles($request->roles);
        }

        if ($request->hasFile('avatar')) {
            $imageController = new ImageController();

            $fileName     =
                $imageController->saveFile(
                    $request,
                    null,
                    'image',
                    'avatars'
                );
            $user->avatar = $fileName;
        }


        $user->syncAddresses($request->input('address'), $request->input('country'), $request->input('state'), $request->input('city'));

        $user->save();

        // Mail::to($user->owner)->send(new TaskModificationNotification($user));

        // event(new TaskModified($user));

        return redirect()->route('admin.user.show', [$user])
            ->with('status', __('basic.actions.modified', ['name' => $this->getModelName()]));
    }

    public function restore(Request $request)
    {
        $request->validate(['user' => 'required|exists:users,id']);
        $user = User::withTrashed()->findOrFail($request->input('user'));

        $user->restore();

        return redirect()->route('admin.user.show', $user)->with('success', __('basic.actions.recovered', ['name' => $this->getModelName()]));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user)
    {
        $user->delete();
        return redirect()->route('admin.user.index')->with('success', __('basic.actions.deleted', ['name' => $this->getModelName()]));
    }

    public function delete(Request $request)
    {
        $request->validate(['user' => 'required|exists:users,id']);
        $user = User::withTrashed()->findOrFail($request->input('user'));

        $user->forceDelete();

        return redirect()->route('admin.user.index')->with('success', __('basic.actions.permanent_deleted', ['name' => $this->getModelName()]));
    }

    protected static function requiresPermission()
    {
        return true;
    }

    protected static function getPermissionKey()
    {
        return 'users';
    }

    public static function getModelName()
    {
        return 'User';
    }
    public static function getAllowedFilters()
    {

        return [
            'first_name' => [
                'type' => 'input',
                'title' => 'First Name'
            ],
            'last_name' => [
                'type' => 'input',
                'title' => 'Last Name'
            ],
            'email' => [
                'type' => 'input',
                'title' => 'Email'
            ]
        ];
    }
}
