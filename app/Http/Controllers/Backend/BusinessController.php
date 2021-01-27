<?php

namespace App\Http\Controllers\Backend;

use App\Business;
use App\User;
use App\Http\Requests\BusinessStoreRequest;
use App\Http\Requests\BusinessUpdateRequest;
use Spatie\QueryBuilder\QueryBuilder;

use Illuminate\Http\Request;

class BusinessController extends Controller
{
    protected $allowedFilters = ['title'];

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $allowedFilters = $this->allowedFilters;

        $businesses = QueryBuilder::for(Business::class)
            ->allowedFilters($allowedFilters)
            ->latest()
            ->paginate();

        $authKey = $this->getPermissionKey();
        $addNew = auth()->user()->can("backend.{$authKey}.create");

        return view('backend.business.index', compact(['allowedFilters', 'businesses', 'addNew']));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
    */
    public function trashed(Request $request)
    {
        $allowedFilters = $this->allowedFilters;

        $businesses = QueryBuilder::for(Business::class)
            ->onlyTrashed()
            ->allowedFilters($allowedFilters)
            // ->allowedIncludes(['tags'])
            // ->allowedAppends(['status'])
            // ->withDisabled()
            ->latest()
            ->paginate();

        $authKey = $this->getPermissionKey();
        $addNew = false; // auth()->user()->can("backend.{$authKey}.create");

        return view('backend.business.index', compact(['allowedFilters', 'businesses', 'addNew']))
            ->with('pageHeader', 'Trashed');
    }

    public function show(Request $request,  Business $business)
    {
        $form = [
            'title' => 'Update',
            'action' => 'edit',
            'action_route' => route('admin.business.update', $business),
            'passwords' => true,
            'method' => 'PATCH',
        ];

        $users = User::all();


        return view('backend.business.single', compact(['business', 'form', 'users']));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request )
    {
        $business = new Business();

        $form = [
            'title' => 'Create',
            'action' => 'create',
            'passwords' => true,
            'action_route' => route('admin.business.store'),
            'method' => 'POST',
        ];

        $users = User::all();


        return view('backend.business.single', compact(['business', 'form', 'users']));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Business $business)
    {
        return redirect()->route('admin.business.show', [$business]);
    }

    /**
     * @param \App\Http\Requests\ProjectStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(BusinessStoreRequest $request)
    {
        $business = Business::create($request->only([
            'title',
            'description',
            'prefix',
            'owner_id'
        ]));


        return redirect()->route('admin.business.index');
    }

    /**
     * @param \App\Http\Requests\ProjectUpdateRequest $request
     * @param \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function update(BusinessUpdateRequest $request, Business $business)
    {
        $business->fill($request->only([
            'title',
            'description',
            'prefix',
            'owner_id'
        ]));

        $business->save();


        return redirect()->route('admin.business.show', [$business])
            ->with('status', __('basic.actions.modified', ['name' => $this->getModelName()]));
    }

    public function restore(Request $request)
    {
        $request->validate(['business' => 'required|exists:businesses,id']);
        $business = Business::withTrashed()->findOrFail($request->input('business'));

        $business->restore();

        return redirect()->route('admin.business.show', $business)->with('success', __('basic.actions.recovered', ['name' => $this->getModelName()]));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Business $business)
    {
        $business->delete();
        return redirect()->route('admin.business.index')->with('success', __('basic.actions.deleted', ['name' => $this->getModelName()]));
    }

    public function delete(Request $request)
    {
        $request->validate(['business' => 'required|exists:businesses,id']);
        $business = Business::withTrashed()->findOrFail($request->input('business'));

        $business->forceDelete();

        return redirect()->route('admin.business.index')->with('success', __('basic.actions.permanent_deleted', ['name' => $this->getModelName()]));
    }


    protected static function requiresPermission ()
    {
        return true;
    }

    protected static function getPermissionKey()
    {
        return 'business';
    }

    public static function getModelName ()
    {
        return 'Business';
    }


}