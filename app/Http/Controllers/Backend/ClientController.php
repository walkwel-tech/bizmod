<?php

namespace App\Http\Controllers\Backend;

use App\Business;
use App\Client;
use App\Helpers\SelectObject;
use App\Http\Requests\ClientStoreRequest;
use App\Http\Requests\ClientUpdateRequest;
use App\Repositories\LocationsRepository;
use Spatie\QueryBuilder\QueryBuilder;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ClientController extends Controller
{


    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $allowedFilters = $this->getAllowedFilters();

        $clients = QueryBuilder::for(Client::class)
            ->with(['businesses' => function ($q) {
                return $q->select(['title', 'prefix']);
            }])
            ->allowedFilters(array_keys($allowedFilters))
            ->latest()
            //->withCount(['codes'])
            ->paginate();

        $authKey = $this->getPermissionKey();
        $addNew = auth()->user()->can("backend.{$authKey}.create");

        $searchedParams = $request->input('filter');

        Session::put('client.filters', $searchedParams);

        return view('backend.client.index', compact(['allowedFilters', 'searchedParams', 'clients', 'addNew']));
    }
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
    */
    public function trashed(Request $request)
    {
        $allowedFilters = $this->allowedFilters;

        $clients = QueryBuilder::for(Client::class)
            ->onlyTrashed()
            ->allowedFilters($allowedFilters)
            // ->allowedIncludes(['tags'])
            // ->allowedAppends(['status'])
            // ->withDisabled()
            ->latest()
            ->paginate();

        $authKey = $this->getPermissionKey();
        $addNew = false; // auth()->user()->can("backend.{$authKey}.create");

        $searchedParams = $request->input('filter');

        return view('backend.client.index', compact(['allowedFilters',  'searchedParams', 'clients', 'addNew']))
            ->with('pageHeader', 'Trashed');
    }

    public function show(Request $request, LocationsRepository $locationsRepository,  Client $client)
    {
        $form = [
            'title' => 'Update',
            'action' => 'edit',
            'action_route' => route('admin.client.update', $client),
            'passwords' => true,
            'method' => 'PATCH',
        ];

        $countries = $locationsRepository->getCountries();

        $backURL = route('admin.client.index', ['filter' => Session::get('client.filters', [])]);

        return view('backend.client.single', compact(['client', 'form', 'countries','backURL']));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, LocationsRepository $locationsRepository )
    {
        $client = new Client();

        $form = [
            'title' => 'Create',
            'action' => 'create',
            'passwords' => true,
            'action_route' => route('admin.client.store'),
            'method' => 'POST',
        ];

        $countries = $locationsRepository->getCountries();


        return view('backend.client.single', compact(['client', 'form', 'countries']));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Client $client)
    {
        return redirect()->route('admin.client.show', [$client]);
    }

    /**
     * @param \App\Http\Requests\ProjectStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientStoreRequest $request)
    {
        $client = Client::create($request->only([
            'first_name',
            'last_name',
            'email',
            'phone',
            'country_name',
            'country_code',
            'zip'
        ]));


        return redirect()->route('admin.client.index');
    }

    /**
     * @param \App\Http\Requests\ProjectUpdateRequest $request
     * @param \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function update(ClientUpdateRequest $request, Client $client)
    {
        $client->fill($request->only([
            'first_name',
            'last_name',
            'email',
            'phone',
            'country_name',
            'country_code',
            'zip'
        ]));

        $client->save();

        return redirect()->route('admin.client.show', [$client])
            ->with('status', __('basic.actions.modified', ['name' => $this->getModelName()]));
    }


    public function restore(Request $request)
    {
        $request->validate(['client' => 'required|exists:clients,id']);
        $client = Client::withTrashed()->findOrFail($request->input('client'));

        $client->restore();

        return redirect()->route('admin.client.show', $client)->with('success', __('basic.actions.recovered', ['name' => $this->getModelName()]));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Client $client)
    {
        $client->delete();
        return redirect()->route('admin.client.index')->with('success', __('basic.actions.deleted', ['name' => $this->getModelName()]));
    }

    public function delete(Request $request)
    {
        $request->validate(['client' => 'required|exists:clients,id']);
        $client = Client::withTrashed()->findOrFail($request->input('client'));

        $client->forceDelete();

        return redirect()->route('admin.client.index')->with('success', __('basic.actions.permanent_deleted', ['name' => $this->getModelName()]));
    }


    protected static function requiresPermission ()
    {
        return true;
    }

    protected static function getPermissionKey()
    {
        return 'clients';
    }

    public static function getModelName ()
    {
        return 'Client';
    }

    public static function getAllowedFilters()
    {

        return [
            'businesses.prefix' => [
                'type' => 'select',
                'title' => 'Business',
                'options' => Business::select(['title', 'prefix'])->pluck('title', 'prefix')->map(function ($value, $key) {
                    return new SelectObject($key, "{$value} ({$key})");
                })->prepend(new SelectObject("", "Select Business"))
            ],
            'first_name' => [
                'type' => 'input',
                'title' => 'First Name'
            ],
            'email' => [
                'type' => 'input',
                'title' => 'Email'
            ],
            'phone' => [
                'type' => 'input',
                'title' => 'Phone'
            ],
            'country' => [
                'type' => 'input',
                'title' => 'Country'
            ]
        ];
    }

}
