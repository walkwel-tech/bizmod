<?php

namespace App\Http\Controllers\Backend;

use App\Code;
use App\Business;
use App\Helpers\SelectObject;
use App\Http\Requests\CodeStoreRequest;
use App\Http\Requests\CodeUpdateRequest;
use Spatie\QueryBuilder\QueryBuilder;

use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;

class CodeController extends Controller
{
    protected $allowedFilters = ['code', 'batch_no', 'business.title', 'client.email'];

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $allowedFilters = $this->allowedFilters;

        $codes = QueryBuilder::for(Code::class)
            ->allowedFilters(array_merge(
                $allowedFilters,
                [
                    AllowedFilter::scope('claimed', 'claimed'),
                    AllowedFilter::scope('claimed_between', 'claimedBetween'),
                ]
            ))
            ->latest()
            ->paginate()
            ->appends($request->query());

        $authKey = $this->getPermissionKey();
        $addNew = auth()->user()->can("backend.{$authKey}.create");

        $searchedParams = $request->input('filter');
        $searchedParams['claimed_on_start'] = $request->input('claimed_on_start');
        $searchedParams['claimed_on_end'] = $request->input('claimed_on_end');

        return view('backend.code.index', compact(['allowedFilters', 'searchedParams', 'codes', 'addNew']));
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

        $searchedParams = $request->input('filter');
        $searchedParams['claimed_on_start'] = $request->input('claimed_on_start');
        $searchedParams['claimed_on_end'] = $request->input('claimed_on_end');

        return view('backend.code.index', compact(['allowedFilters', 'searchedParams', 'codes', 'addNew']))
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

        $businessOptions = $this->getAvailableBusinessOptions();

        return view('backend.code.single', compact(['code', 'form' ,'businessOptions']));
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

        $businessOptions = $this->getAvailableBusinessOptions();

        return view('backend.code.single', compact(['code', 'form' ,'businessOptions']));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function showBatchForm(Request $request )
    {
        $form = [
            'title' => 'Batch Notes',
            'action' => 'create',
            'passwords' => true,
            'action_route' => route('admin.code.batch'),
            'method' => 'POST',
        ];

        $batches = Code::distinct('batch_no')->pluck('batch_no')->mapInto(SelectObject::class);

        return view('backend.code.batch', compact(['form' ,'batches']));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function updateBatch(Request $request )
    {
       // dd($request->input('batch_no'));
        Code::where('batch_no',  $request->input('batch_no'))->update(['description' => $request->input('description')]);

        return redirect()->route('admin.code.index', ['filter' => ['batch_no' => $request->input('batch_no')]])->with('success', __('basic.actions.modified', ['name' => $this->getModelName()]));

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
        $business = Business::findOrFail($request->input('business_id'));
        $codes = $business->generateRandomCodes(
            $request->input('no_of_codes'),
            $request->input('batch_no'),
            $request->input('prefix')
        );

        $batchNo = $codes->first()->batch_no;

        return redirect()->route('admin.code.index', ['filter' => ['batch_no' => $batchNo]]);
    }

    /**
     * @param \App\Http\Requests\ProjectUpdateRequest $request
     * @param \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function update(CodeUpdateRequest $request, Code $code)
    {
        $code->fill($request->only([
            'description'
        ]));

        $code->save();

        return redirect()->route('admin.code.show', $code)->with('success', __('basic.actions.modified', ['name' => $this->getModelName()]));
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


    private function getAvailableBusinessOptions() {
        $businessOptions = Business::all();

        return $businessOptions;
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
