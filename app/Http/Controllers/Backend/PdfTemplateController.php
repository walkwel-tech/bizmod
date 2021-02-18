<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\ImageController;

use App\Business;
use App\Http\Requests\PdfTemplateStoreRequest;
use App\Http\Requests\PdfTemplateUpdateRequest;
use App\PdfTemplate;
use Spatie\QueryBuilder\QueryBuilder;

use Illuminate\Http\Request;

class PdfTemplateController extends Controller
{
    //
    protected $allowedFilters = ['title'];

    public function index(Request $request)
    {
        $allowedFilters = $this->allowedFilters;

        $pdf_templates = QueryBuilder::for(PdfTemplate::class)
            ->allowedFilters($allowedFilters)
            ->latest()
            ->paginate();

        $authKey = $this->getPermissionKey();
        $addNew = auth()->user()->can("backend.{$authKey}.create");


        return view('backend.pdf_template.index', compact(['allowedFilters',  'pdf_templates', 'addNew']));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
    */
    public function trashed(Request $request)
    {
        $allowedFilters = $this->allowedFilters;

        $pdf_templates = QueryBuilder::for(PdfTemplate::class)
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

        return view('backend.pdf_template.index', compact(['allowedFilters', 'pdf_templates', 'addNew']))
            ->with('pageHeader', 'Trashed');
    }

    public function show(Request $request,  PdfTemplate $pdf_template)
    {
        $form = [
            'title' => 'Update',
            'action' => 'edit',
            'action_route' => route('admin.pdf_template.update', $pdf_template),
            'passwords' => true,
            'method' => 'PATCH',
        ];


        return view('backend.pdf_template.single', compact(['pdf_template', 'form']));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request )
    {
        $pdf_template = new PdfTemplate();

        $form = [
            'title' => 'Create',
            'action' => 'create',
            'passwords' => true,
            'action_route' => route('admin.pdf_template.store'),
            'method' => 'POST',
        ];




        return view('backend.pdf_template.single', compact(['pdf_template', 'form']));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, PdfTemplate $pdf_template)
    {
        return redirect()->route('admin.pdf_template.show', [$pdf_template]);
    }

    /**
     * @param \App\Http\Requests\ProjectStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PdfTemplateStoreRequest $request)
    {
        $pdf_template = PdfTemplate::make($request->only([
            'title',
            'description'
        ]));

        //dd($pdf_template->business->title);

        if ($request->hasFile('path')) {
            $imageController = new ImageController();

            $fileName     =
                $imageController->saveFile(
                    $request,
                    null,
                    'pdf',
                    $pdf_template->business->title,
                    'path'
                );
            $pdf_template->path = $fileName;
        }

        $pdf_template->save();

        return redirect()->route('admin.pdf_template.index');
    }

    /**
     * @param \App\Http\Requests\ProjectUpdateRequest $request
     * @param \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function update(PdfTemplateUpdateRequest $request, PdfTemplate $pdf_template)
    {
        $pdf_template->fill($request->only([
            'title',
            'description'

        ]));
       // dd($pdf_template->business->title);
        if ($request->hasFile('path')) {
            $imageController = new ImageController();

            $fileName     =
                $imageController->saveFile(
                    $request,
                    null,
                    'pdf',
                    $pdf_template->business->title,
                    'path'
                );
            $pdf_template->path = $fileName;
        }

        $pdf_template->save();


        return redirect()->route('admin.pdf_template.show', [$pdf_template])
            ->with('status', __('basic.actions.modified', ['name' => $this->getModelName()]));
    }

    public function restore(Request $request)
    {
        $request->validate(['pdf_template' => 'required|exists:pdf_template,id']);
        $pdf_template = PdfTemplate::withTrashed()->findOrFail($request->input('pdf_template'));

        $pdf_template->restore();

        return redirect()->route('admin.pdf_template.show', $pdf_template)->with('success', __('basic.actions.recovered', ['name' => $this->getModelName()]));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, PdfTemplate $pdf_template)
    {
        $pdf_template->delete();
        return redirect()->route('admin.pdf_template.index')->with('success', __('basic.actions.deleted', ['name' => $this->getModelName()]));
    }

    public function delete(Request $request)
    {
        $request->validate(['pdf_template' => 'required|exists:pdf_template,id']);
        $PdfTemplate = PdfTemplate::withTrashed()->findOrFail($request->input('pdf_template'));

        $PdfTemplate->forceDelete();

        return redirect()->route('admin.pdf_template.index')->with('success', __('basic.actions.permanent_deleted', ['name' => $this->getModelName()]));
    }


    protected static function requiresPermission ()
    {
        return true;
    }

    protected static function getPermissionKey()
    {
        return 'pdf_templates';
    }

    public static function getModelName ()
    {
        return 'PdfTemplate';
    }
}
