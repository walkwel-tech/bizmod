<?php

namespace App\Http\Controllers\Backend;

use Storage;
use setasign\Fpdi\Fpdi;


use App\Code;
use App\Business;
use App\Helpers\SelectObject;
use App\Http\Requests\CodeStoreRequest;
use App\Http\Requests\CodeUpdateRequest;
use App\PdfTemplate;
use Spatie\QueryBuilder\QueryBuilder;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Spatie\QueryBuilder\AllowedFilter;

class CodeController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $allowedFilters = $this->getAllowedFilters();

        $codes = QueryBuilder::for(Code::class)
            ->allowedFilters(array_merge(
                array_keys($allowedFilters),
                [
                    AllowedFilter::scope('ClaimedFilter', 'ClaimedFilter'),
                    AllowedFilter::scope('GiventFilter', 'GiventFilter'),
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

        Session::put('code.filters', $searchedParams);

        return view('backend.code.index', compact(['allowedFilters', 'searchedParams', 'codes', 'addNew']));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function trashed(Request $request)
    {
        $allowedFilters = array_keys($this->getAllowedFilters());

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
        $digitalPdfTemplates = $this->getAvailablePdfTemplates('digital');
        $printPdfTemplates = $this->getAvailablePdfTemplates('print ready');


        $backURL = route('admin.code.index', ['filter' => Session::get('code.filters', [])]);


        return view('backend.code.single', compact(['code', 'form', 'businessOptions', 'digitalPdfTemplates', 'printPdfTemplates', 'backURL']));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
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
        $digitalPdfTemplates = $this->getAvailablePdfTemplates('digital');
        $printPdfTemplates = $this->getAvailablePdfTemplates('print ready');

        return view('backend.code.single', compact(['code', 'form', 'businessOptions', 'digitalPdfTemplates', 'printPdfTemplates']));
    }

    public function codeClaimed(Request $request)
    {
        $allowedFilters = $this->getAllowedFilters();

        $codes = QueryBuilder::for(Code::class)
            ->allowedFilters(array_merge(
                array_keys($allowedFilters),
                [
                    AllowedFilter::scope('claimed_between', 'claimedBetween'),
                ]
            ))
            ->claimed()
            ->latest()
            ->paginate()
            ->appends($request->query());

        $authKey = $this->getPermissionKey();
        $addNew = auth()->user()->can("backend.{$authKey}.create");

        $searchedParams = $request->input('filter');
        $searchedParams['claimed_on_start'] = $request->input('claimed_on_start');
        $searchedParams['claimed_on_end'] = $request->input('claimed_on_end');

        return view('backend.code.claimed', compact(['allowedFilters', 'searchedParams', 'codes', 'addNew']));
    }
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function showBatchForm(Request $request)
    {
        $form = [
            'title' => 'Batch Notes',
            'action' => 'create',
            'passwords' => true,
            'action_route' => route('admin.code.batch'),
            'method' => 'POST',
        ];

        $batches = Code::distinct('batch_no')->pluck('batch_no')->map(function ($singleBatchString) {
            return new SelectObject($singleBatchString);
        });

        return view('backend.code.batch', compact(['form', 'batches']));
    }

    public function showPdfForm(Request $request)
    {
        $form = [
            'title' => 'Batch Pdf Generate',
            'action' => 'create',
            'passwords' => true,
            'action_route' => route('admin.template.batch'),
            'method' => 'POST',
        ];

        $batches = Code::distinct('batch_no')->with(['print_ready_template' => function ($query) {
            $query->select('id', 'title');
        }])->get()->mapWithKeys(function ($c) {

            return [$c->batch_no => new SelectObject(
                $c->batch_no,
                $c->batch_no,
                $c->print_ready_template->only(['title', 'id'])
            )];
        });



        return view('backend.code.pdf', compact(['form', 'batches']));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function updateBatch(Request $request)
    {
        // dd($request->input('batch_no'));
        Code::where('batch_no',  $request->input('batch_no'))->update(
            ['expire_on' => $request->input('expire_on'),
            'description' => $request->input('description')
            ]);

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
            $request->input('prefix'),
            $request->input('digital_template_id'),
            $request->input('print_ready_template_id'),
            $request->input('expire_on')
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
            'description',
            'given_on',
            'expire_on'
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


    private function getAvailableBusinessOptions()
    {
        $businessOptions = Business::all();

        return $businessOptions;
    }

    private function getAvailablePdfTemplates($type)
    {
        $businessOptions = Business::all();
        $BusinessPdfTemplate =  $businessOptions->mapWithKeys(function ($businessObj)  use ($type) {

            $pdfTemplate = PdfTemplate::select(['id', 'title as text', 'title as title', 'business_id'])
                ->where('type', '=', $type)
                ->where(function ($query) use ($businessObj) {
                    $query->where('business_id', '=', $businessObj->id)
                        ->orWhereNull('business_id');
                })
                ->orderBy('business_id')
                ->get();

            return [$businessObj->id => $pdfTemplate];
        });
        return $BusinessPdfTemplate;
    }
    // private function getAvailablePrintPdfTemplates()
    // {
    //     $businessOptions = Business::all();
    //     $BusinessPrintPdf =  $businessOptions->mapWithKeys(function ($businessObj) {

    //         $pdfTemplate = PdfTemplate::select(['id', 'title as text', 'title as title', 'business_id'])->where('type', '=', 'print ready')->where('business_id', '=', $businessObj->id)->orWhereNull('business_id')->get();

    //         return [$businessObj->id => $pdfTemplate];
    //     });
    //     return $BusinessPrintPdf;
    // }

    private function groupPDFTemplates($templates)
    {
        $groupedByBusiness = $templates->groupBy('business_id');

        $all = $groupedByBusiness->get("");

        return $groupedByBusiness->forget("")->map(function ($g) use ($all) {

            $g->push($all);

            return $g->flatten();
        });
    }

    protected static function requiresPermission()
    {
        return true;
    }

    protected static function getPermissionKey()
    {
        return 'codes';
    }

    public static function getModelName()
    {
        return 'Code';
    }

    public static function getAllowedFilters()
    {
        return [
            'batch_no' => [
                'type' => 'select',
                'title' => 'Batch No',
                'options' => Code::distinct('batch_no')->pluck('batch_no')->map(function ($singleBatchString) {
                    return new SelectObject($singleBatchString);
                })->prepend(new SelectObject("", "Batch No"))
            ],
            'business.prefix' => [
                'type' => 'select',
                'title' => 'Business',
                'options' => Business::select(['title', 'prefix'])->get()->map(function ($value, $key) {

                    return new SelectObject($value->prefix, $value->getSEOTitle());
                })->prepend(new SelectObject("", "Select Business"))
            ],
            'code' => [
                'type' => 'input',
                'title' => 'Code'
            ],

            'client.email' => [
                'type' => 'input',
                'title' => 'Customer Email'
            ]
        ];
    }
}
