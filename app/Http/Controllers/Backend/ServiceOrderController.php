<?php

namespace App\Http\Controllers\Backend;

use App\ServiceOrder;
use App\Service;
use App\User;
use App\Http\Requests\ServiceOrderStoreRequest;
use App\Http\Requests\ServiceOrderUpdateRequest;
use Spatie\QueryBuilder\QueryBuilder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ServiceOrderController extends Controller
{
    protected $allowedFilters = ['customer_name'];

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $allowedFilters = $this->allowedFilters;

        $service_orders = QueryBuilder::for(ServiceOrder::class)
            ->allowedFilters($allowedFilters)
            ->latest()
            ->paginate();

        $authKey = $this->getPermissionKey();
        $addNew = auth()->user()->can("backend.{$authKey}.create");

        return view('backend.serviceorder.index', compact(['allowedFilters', 'service_orders', 'addNew']));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function trashed(Request $request)
    {
        $allowedFilters = $this->allowedFilters;

        $service_orders = QueryBuilder::for(ServiceOrder::class)
            ->onlyTrashed()
            ->allowedFilters($allowedFilters)
            // ->allowedIncludes(['tags'])
            // ->allowedAppends(['status'])
            // ->withDisabled()
            ->latest()
            ->paginate();

        $authKey = $this->getPermissionKey();
        $addNew = false; // auth()->user()->can("backend.{$authKey}.create");

        return view('backend.serviceorder.index', compact(['allowedFilters', 'service_orders', 'addNew']))
            ->with('pageHeader', 'Trashed');
    }

    public function show(Request $request,  ServiceOrder $serviceorder)
    {
        $form = [
            'title' => 'Update',
            'action' => 'edit',
            'action_route' => route('admin.serviceorder.update', $serviceorder),
            'passwords' => true,
            'method' => 'PATCH',
        ];
        $services = Service::all();
        $users = User::whereHas(
            'roles', function($q){
                $q->where('name', 'user');
            }
        )->get();
        $status = array("requested","assigned to vendor","bill generated","payment done","close");

        return view('backend.serviceorder.single', compact(['serviceorder', 'form', 'services','users','status']));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $serviceorder = new ServiceOrder();

        $form = [
            'title' => 'Create',
            'action' => 'create',
            'passwords' => true,
            'action_route' => route('admin.serviceorder.store'),
            'method' => 'POST',
        ];

        $services = Service::all();
        $users = User::whereHas(
            'roles', function($q){
                $q->where('name', 'user');
            }
        )->get();
        $status = array("requested","assigned to vendor","bill generated","payment done","close");

        return view('backend.serviceorder.single', compact(['serviceorder', 'form', 'services','users','status']));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, ServiceOrder $serviceorder)
    {
        return redirect()->route('admin.serviceorder.show', [$serviceorder]);
    }

    /**
     * @param \App\Http\Requests\ServiceStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->all());
        $serviceorder = ServiceOrder::create($request->only([
            'customer_id',
            'user_id',
            'service_id',
            'amount',
            'from_at',
            'to_at',
            'address',
            'pincode',
            'phone_number',
            'status'
        ]));


        return redirect()->route('admin.serviceorder.index');
    }

    /**
     * @param \App\Http\Requests\ServiceUpdateRequest $request
     * @param \App\Service $service
     * @return \Illuminate\Http\Response
     */
    public function update(ServiceOrderUpdateRequest $request, ServiceOrder $serviceorder)
    {
        $serviceorder->fill($request->only([
            'customer_id',
            'user_id',
            'service_id',
            'amount',
            'from_at',
            'to_at',
            'address',
            'pincode',
            'phone_number',
            'status'
        ]));


        $serviceorder->save();


        return redirect()->route('admin.serviceorder.show', [$serviceorder])
            ->with('status', __('basic.actions.modified', ['name' => $this->getModelName()]));
    }


    public function restore(Request $request)
    {
        $request->validate(['serviceorder' => 'required|exists:service_orders,id']);
        $serviceorder = ServiceOrder::withTrashed()->findOrFail($request->input('serviceorder'));

        $serviceorder->restore();

        return redirect()->route('admin.serviceorder.show', $serviceorder)->with('success', __('basic.actions.recovered', ['name' => $this->getModelName()]));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ServiceOrder $serviceorder)
    {
        $serviceorder->delete();
        return redirect()->route('admin.serviceorder.index')->with('success', __('basic.actions.deleted', ['name' => $this->getModelName()]));
    }

    public function delete(Request $request)
    {
        $request->validate(['serviceorder' => 'required|exists:service_orders,id']);
        $serviceorder = ServiceOrder::withTrashed()->findOrFail($request->input('serviceorder'));

        $serviceorder->forceDelete();

        return redirect()->route('admin.serviceorder.index')->with('success', __('basic.actions.permanent_deleted', ['name' => $this->getModelName()]));
    }


    protected static function requiresPermission()
    {
        return true;
    }

    protected static function getPermissionKey()
    {
        return 'service_orders';
    }

    public static function getModelName()
    {
        return 'ServiceOrder';
    }
}
