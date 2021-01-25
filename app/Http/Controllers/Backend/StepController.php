<?php

namespace App\Http\Controllers\Backend;

use App\Service;
use App\Step;
use App\Http\Requests\StepStoreRequest;
use App\Http\Requests\StepUpdateRequest;
use Spatie\QueryBuilder\QueryBuilder;

use Illuminate\Http\Request;

class StepController extends Controller
{
    protected $allowedFilters = ['title'];

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $allowedFilters = $this->allowedFilters;

        $steps = QueryBuilder::for(Step::class)
            ->allowedFilters($allowedFilters)
            ->latest()
            ->paginate();

        $authKey = $this->getPermissionKey();
        $addNew = auth()->user()->can("backend.{$authKey}.create");

        return view('backend.step.index', compact(['allowedFilters', 'steps', 'addNew']));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function trashed(Request $request)
    {
        $allowedFilters = $this->allowedFilters;

        $steps = QueryBuilder::for(Step::class)
            ->onlyTrashed()
            ->allowedFilters($allowedFilters)
            // ->allowedIncludes(['tags'])
            // ->allowedAppends(['status'])
            // ->withDisabled()
            ->latest()
            ->paginate();

        $authKey = $this->getPermissionKey();
        $addNew = false; // auth()->user()->can("backend.{$authKey}.create");

        return view('backend.step.index', compact(['allowedFilters', 'steps', 'addNew']))
            ->with('pageHeader', 'Trashed');
    }

    public function show(Request $request,  Step $step)
    {
        $form = [
            'title' => 'Update',
            'action' => 'edit',
            'action_route' => route('admin.step.update', $step),
            'passwords' => true,
            'method' => 'PATCH',
        ];
        $services = Service::all();

        return view('backend.step.single', compact(['step', 'form', 'services']));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $step = new Step();

        $form = [
            'title' => 'Create',
            'action' => 'create',
            'passwords' => true,
            'action_route' => route('admin.step.store'),
            'method' => 'POST',
        ];

        $services = Service::all();

        return view('backend.step.single', compact(['step', 'form', 'services']));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Step $step)
    {
        return redirect()->route('admin.step.show', [$step]);
    }

    /**
     * @param \App\Http\Requests\StepStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $step = Step::create($request->only([
            'title',
            'description',
            'content',
            'fields',
            'order',
            'submitable',
            'service_id'
        ]));


        return redirect()->route('admin.step.index');
    }

    /**
     * @param \App\Http\Requests\StepUpdateRequest $request
     * @param \App\Service $service
     * @return \Illuminate\Http\Response
     */
    public function update(StepUpdateRequest $request, Step $step)
    {
        $step->fill($request->only([
            'title',
            'description',
            'content',
            'fields',
            'order',
            'submitable',
            'service_id'
        ]));


        $step->save();


        return redirect()->route('admin.step.show', [$step])
            ->with('status', __('basic.actions.modified', ['name' => $this->getModelName()]));
    }


    public function restore(Request $request)
    {
        $request->validate(['step' => 'required|exists:steps,id']);
        $step = Step::withTrashed()->findOrFail($request->input('step'));

        $step->restore();

        return redirect()->route('admin.step.show', $step)->with('success', __('basic.actions.recovered', ['name' => $this->getModelName()]));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Step $step)
    {
        $step->delete();
        return redirect()->route('admin.step.index')->with('success', __('basic.actions.deleted', ['name' => $this->getModelName()]));
    }

    public function delete(Request $request)
    {
        $request->validate(['step' => 'required|exists:steps,id']);
        $step = Step::withTrashed()->findOrFail($request->input('step'));

        $step->forceDelete();

        return redirect()->route('admin.step.index')->with('success', __('basic.actions.permanent_deleted', ['name' => $this->getModelName()]));
    }


    protected static function requiresPermission()
    {
        return true;
    }

    protected static function getPermissionKey()
    {
        return 'steps';
    }

    public static function getModelName()
    {
        return 'Step';
    }
}
