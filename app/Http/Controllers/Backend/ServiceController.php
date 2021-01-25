<?php

namespace App\Http\Controllers\Backend;

use App\Service;
use App\Category;
use App\Http\Requests\ServiceStoreRequest;
use App\Http\Requests\ServiceUpdateRequest;
use Spatie\QueryBuilder\QueryBuilder;

use Illuminate\Http\Request;

class ServiceController extends Controller
{
    protected $allowedFilters = ['title'];

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $allowedFilters = $this->allowedFilters;

        $services = QueryBuilder::for(Service::class)
            ->allowedFilters($allowedFilters)
            ->latest()
            ->paginate();

        $authKey = $this->getPermissionKey();
        $addNew = auth()->user()->can("backend.{$authKey}.create");

        return view('backend.service.index', compact(['allowedFilters', 'services', 'addNew']));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function trashed(Request $request)
    {
        $allowedFilters = $this->allowedFilters;

        $services = QueryBuilder::for(Service::class)
            ->onlyTrashed()
            ->allowedFilters($allowedFilters)
            // ->allowedIncludes(['tags'])
            // ->allowedAppends(['status'])
            // ->withDisabled()
            ->latest()
            ->paginate();

        $authKey = $this->getPermissionKey();
        $addNew = false; // auth()->user()->can("backend.{$authKey}.create");

        return view('backend.service.index', compact(['allowedFilters', 'services', 'addNew']))
            ->with('pageHeader', 'Trashed');
    }

    public function show(Request $request,  Service $service)
    {
        $form = [
            'title' => 'Update',
            'action' => 'edit',
            'action_route' => route('admin.service.update', $service),
            'passwords' => true,
            'method' => 'PATCH',
        ];
        $categories = Category::all();

        return view('backend.service.single', compact(['service', 'form', 'categories']));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $service = new Service();

        $form = [
            'title' => 'Create',
            'action' => 'create',
            'passwords' => true,
            'action_route' => route('admin.service.store'),
            'method' => 'POST',
        ];

        $categories = Category::all();

        return view('backend.service.single', compact(['service', 'form', 'categories']));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Service $service)
    {
        return redirect()->route('admin.service.show', [$service]);
    }

    /**
     * @param \App\Http\Requests\ServiceStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceStoreRequest $request)
    {
        $service = Service::create($request->only([
            'title',
            'description',
            'amount'
        ]));
        $service->categories()->sync(array_keys($request->input('category')??array()));    

        return redirect()->route('admin.service.index');
    }

    /**
     * @param \App\Http\Requests\ServiceUpdateRequest $request
     * @param \App\Service $service
     * @return \Illuminate\Http\Response
     */
    public function update(ServiceUpdateRequest $request, Service $service)
    {
        $service->fill($request->only([
            'title',
            'description',
            'amount',
        ]));

        $service->categories()->sync(array_keys($request->input('category')??array()));    
        $service->save();


        return redirect()->route('admin.service.show', [$service])
            ->with('status', __('basic.actions.modified', ['name' => $this->getModelName()]));
    }


    public function restore(Request $request)
    {
        $request->validate(['service' => 'required|exists:services,id']);
        $service = Service::withTrashed()->findOrFail($request->input('service'));

        $service->restore();

        return redirect()->route('admin.service.show', $service)->with('success', __('basic.actions.recovered', ['name' => $this->getModelName()]));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Service $service)
    {
        $service->delete();
        return redirect()->route('admin.service.index')->with('success', __('basic.actions.deleted', ['name' => $this->getModelName()]));
    }

    public function delete(Request $request)
    {
        $request->validate(['service' => 'required|exists:services,id']);
        $service = Service::withTrashed()->findOrFail($request->input('service'));

        $service->forceDelete();

        return redirect()->route('admin.service.index')->with('success', __('basic.actions.permanent_deleted', ['name' => $this->getModelName()]));
    }


    protected static function requiresPermission()
    {
        return true;
    }

    protected static function getPermissionKey()
    {
        return 'services';
    }

    public static function getModelName()
    {
        return 'Service';
    }
}
