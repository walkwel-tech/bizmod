<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\ImageController;
use Storage;
use setasign\Fpdi\Fpdi;

use App\Business;
use App\Helpers\TemplateConfiguration;
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

    public function show(Request $request,  PdfTemplate $template)
    {
        $form = [
            'title' => 'Update',
            'action' => 'edit',
            'action_route' => route('admin.template.update', $template),
            'passwords' => true,
            'method' => 'PATCH',
        ];

        $businessOptions = $this->getAvailableBusinessOptions();

        return view('backend.pdf_template.single', compact(['template', 'form', 'businessOptions']));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request )
    {
        $template = new PdfTemplate();

        $form = [
            'title' => 'Create',
            'action' => 'create',
            'passwords' => true,
            'action_route' => route('admin.template.store'),
            'method' => 'POST',
        ];

        $businessOptions = $this->getAvailableBusinessOptions();

        return view('backend.pdf_template.single', compact(['template', 'form', 'businessOptions']));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, PdfTemplate $pdf_template)
    {
        return redirect()->route('admin.template.show', [$pdf_template]);
    }

    /**
     * @param \App\Http\Requests\ProjectStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PdfTemplateStoreRequest $request)
    {
        $business = Business::findOrFail($request->input('business_id'));
        $pdf_template = PdfTemplate::make($request->only([
            'title',
            'description'
        ]));

        $pdf_template->configuration = new TemplateConfiguration($request->input('business'), $request->input('code'));

        //dd($pdf_template->business->title);

        if ($request->hasFile('path')) {
            $imageController = new ImageController();

            $fileName     =
                $imageController->saveFile(
                    $request,
                    null,
                    'pdf',
                    '',
                    'path'
                );
            $pdf_template->path = $fileName;
        }

        $business->templates()->save($pdf_template);

        return redirect()->route('admin.template.index');
    }

    /**
     * @param \App\Http\Requests\ProjectUpdateRequest $request
     * @param \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function update(PdfTemplateUpdateRequest $request, PdfTemplate $template)
    {
        $template->fill($request->only([
            'title',
            'description',
            'business_id'

        ]));

        $template->configuration->business = $request->input('business');
        $template->configuration->code = $request->input('code');

        if ($request->hasFile('path')) {
            $imageController = new ImageController();

            $fileName     =
                $imageController->saveFile(
                    $request,
                    null,
                    'pdf',
                    '',
                    'path'
                );
            $template->path = $fileName;
        }

        $template->save();


        return redirect()->route('admin.template.show', [$template])
            ->with('status', __('basic.actions.modified', ['name' => $this->getModelName()]));
    }

    public function restore(Request $request)
    {
        $request->validate(['pdf_template' => 'required|exists:pdf_templates,id']);
        $pdf_template = PdfTemplate::withTrashed()->findOrFail($request->input('pdf_template'));

        $pdf_template->restore();

        return redirect()->route('admin.template.show', $pdf_template)->with('success', __('basic.actions.recovered', ['name' => $this->getModelName()]));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, PdfTemplate $template)
    {
        $template->delete();
        return redirect()->route('admin.template.index')->with('success', __('basic.actions.deleted', ['name' => $this->getModelName()]));
    }

    public function delete(Request $request)
    {
        $request->validate(['pdf_template' => 'required|exists:pdf_templates,id']);
        $PdfTemplate = PdfTemplate::withTrashed()->findOrFail($request->input('pdf_template'));

        $PdfTemplate->forceDelete();

        return redirect()->route('admin.template.index')->with('success', __('basic.actions.permanent_deleted', ['name' => $this->getModelName()]));
    }



    private function getAvailableBusinessOptions()
    {
        $businessOptions = Business::all();

        return $businessOptions;
    }


    protected static function requiresPermission ()
    {
        return true;
    }

    protected static function getPermissionKey()
    {
        return 'templates';
    }

    public static function getModelName ()
    {
        return 'PdfTemplate';
    }
}
