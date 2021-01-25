<?php

namespace App\Http\Controllers\Frontend;


use App\ServiceOrder;
use App\Service;
use App\User;

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
        $services = QueryBuilder::for(Service::class)
        ->latest()
        ->paginate();

        return view('frontend.service.index', compact([ 'services']));
    }


    public function show(Request $request, Service $service)
    {
        return view('frontend.service.single', compact(['service']));
    }

    public function order(Request $request, Service $service)
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

        return view('frontend.service.request', compact(['serviceorder', 'form', 'services', 'service', 'users', 'status']));
    }

    protected static function requiresPermission ()
    {
        return false;
    }

    protected static function getPermissionKey ()
    {
        return 'services';
    }
}
