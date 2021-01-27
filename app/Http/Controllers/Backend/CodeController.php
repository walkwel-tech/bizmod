<?php

namespace App\Http\Controllers\Backend;

use App\Code;
use App\Business;
use App\Http\Requests\CodeStoreRequest;
use App\Http\Requests\CodeUpdateRequest;
use Spatie\QueryBuilder\QueryBuilder;

use Illuminate\Http\Request;

class CodeController extends Controller
{
    protected $allowedFilters = ['code'];

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $allowedFilters = $this->allowedFilters;

        $codes = QueryBuilder::for(Code::class)
            ->allowedFilters($allowedFilters)
            ->latest()
            ->paginate();

        $authKey = $this->getPermissionKey();
        $addNew = auth()->user()->can("backend.{$authKey}.create");

        return view('backend.code.index', compact(['allowedFilters', 'codes', 'addNew']));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
    */
    public function trashed(Request $request)
    {
        $allowedFilters = $this->allowedFilters;

        $codes = QueryBuilder::for(Code::class)
            ->onlyTrashed()
            ->allowedFilters($allowedFilters)
            // ->allowedIncludes(['tags'])
            // ->allowedAppends(['status'])
            // ->withDisabled()
            ->latest()
            ->paginate();

        $authKey = $this->getPermissionKey();
        $addNew = false; // auth()->user()->can("backend.{$authKey}.create");

        return view('backend.code.index', compact(['allowedFilters', 'codes', 'addNew']))
            ->with('pageHeader', 'Trashed');
    }

    public function show(Request $request,  Code $code)
    {
        $form = [
            'title' => 'Update',
            'action' => 'edit',
            'action_route' => route('admin.code.update', $code),
            'passwords' => true,
            'method' => 'PATCH',
        ];

        $business = Business::all();

        return view('backend.code.single', compact(['code', 'form' ,'business']));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request )
    {
        $code = new Code();

        $form = [
            'title' => 'Create',
            'action' => 'create',
            'passwords' => true,
            'action_route' => route('admin.code.store'),
            'method' => 'POST',
        ];

        $business = Business::all();

        return view('backend.code.single', compact(['code', 'form' ,'business']));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Code $code)
    {
        return redirect()->route('admin.code.show', [$code]);
    }

    /**
     * @param \App\Http\Requests\ProjectStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CodeStoreRequest $request)
    {
        $code = Code::create($request->only([
            'batch_no',
            'code',
            'business_id'
        ]));


        return redirect()->route('admin.code.index');
    }

    /**
     * @param \App\Http\Requests\ProjectUpdateRequest $request
     * @param \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function update(CodeUpdateRequest $request, Code $code)
    {
        $code->fill($request->only([
            'batch_no',
            'code',
            'business_id'
        ]));

        $code->save();


        return redirect()->route('admin.code.show', [$code])
            ->with('status', __('basic.actions.modified', ['name' => $this->getModelName()]));
    }

    public function restore(Request $request)
    {
        $request->validate(['code' => 'required|exists:codes,id']);
        $code = Code::withTrashed()->findOrFail($request->input('code'));

        $code->restore();

        return redirect()->route('admin.code.show', $code)->with('success', __('basic.actions.recovered', ['name' => $this->getModelName()]));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Code $code)
    {
        $code->delete();
        return redirect()->route('admin.code.index')->with('success', __('basic.actions.deleted', ['name' => $this->getModelName()]));
    }

    public function delete(Request $request)
    {
        $request->validate(['code' => 'required|exists:codes,id']);
        $code = Code::withTrashed()->findOrFail($request->input('code'));

        $code->forceDelete();

        return redirect()->route('admin.code.index')->with('success', __('basic.actions.permanent_deleted', ['name' => $this->getModelName()]));
    }

    protected static function requiresPermission ()
    {
        return true;
    }

    protected static function getPermissionKey()
    {
        return 'codes';
    }

    public static function getModelName ()
    {
        return 'Code';
    }



}
