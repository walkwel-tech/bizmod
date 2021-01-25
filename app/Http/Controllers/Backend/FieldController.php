<?php

namespace App\Http\Controllers\Backend;

use App\Step;
use App\Field;
use App\Http\Requests\FieldStoreRequest;
use App\Http\Requests\FieldUpdateRequest;
use Spatie\QueryBuilder\QueryBuilder;

use Illuminate\Http\Request;

class FieldController extends Controller
{
    protected $allowedFilters = ['title'];

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $allowedFilters = $this->allowedFilters;

        $fields = QueryBuilder::for(Field::class)
            ->allowedFilters($allowedFilters)
            ->latest()
            ->paginate();

        $authKey = $this->getPermissionKey();
        $addNew = auth()->user()->can("backend.{$authKey}.create");

        return view('backend.field.index', compact(['allowedFilters', 'fields', 'addNew']));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function trashed(Request $request)
    {
        $allowedFilters = $this->allowedFilters;

        $fields = QueryBuilder::for(Field::class)
            ->onlyTrashed()
            ->allowedFilters($allowedFilters)
            // ->allowedIncludes(['tags'])
            // ->allowedAppends(['status'])
            // ->withDisabled()
            ->latest()
            ->paginate();

        $authKey = $this->getPermissionKey();
        $addNew = false; // auth()->user()->can("backend.{$authKey}.create");

        return view('backend.field.index', compact(['allowedFilters', 'fields', 'addNew']))
            ->with('pageHeader', 'Trashed');
    }

    public function show(Request $request,  Field $field)
    {
        $form = [
            'title' => 'Update',
            'action' => 'edit',
            'action_route' => route('admin.field.update', $field),
            'passwords' => true,
            'method' => 'PATCH',
        ];
        $steps = Step::all();
        $typeOptions= array();
        $typeOptions = [
            'text'=> 'Text',
            'textarea'=> 'Textarea',
            'select'=> 'Select',
            'radio'=> 'Radio',
            'checkbox'=> 'Checkbox',
            ];
        return view('backend.field.single', compact(['field', 'form', 'steps','typeOptions']));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $field = new Field();

        $form = [
            'title' => 'Create',
            'action' => 'create',
            'passwords' => true,
            'action_route' => route('admin.field.store'),
            'method' => 'POST',
        ];

        $steps = Step::all();
        $typeOptions= array();
        $typeOptions = [
            'text'=> 'Text',
            'textarea'=> 'Textarea',
            'select'=> 'Select',
            'radio'=> 'Radio',
            'checkbox'=> 'Checkbox',
            ];
        return view('backend.field.single', compact(['field', 'form', 'steps','typeOptions']));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Field $field)
    {
        return redirect()->route('admin.field.show', [$field]);
    }

    /**
     * @param \App\Http\Requests\FieldStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      //  dd($request->all());
        $field = Field::create($request->only([
            'title',
            'name',
            'type',
            'mapped_to',
            'placeholder',
            'required',
            'step_id'
        ]));


        return redirect()->route('admin.field.index');
    }

    /**
     * @param \App\Http\Requests\FieldUpdateRequest $request
     * @param \App\Service $service
     * @return \Illuminate\Http\Response
     */
    public function update(FieldUpdateRequest $request, Field $field)
    {
        $field->fill($request->only([
            'title',
            'name',
            'type',
            'mapped_to',
            'placeholder',
            'required',
            'step_id'
        ]));


        $field->save();


        return redirect()->route('admin.field.show', [$field])
            ->with('status', __('basic.actions.modified', ['name' => $this->getModelName()]));
    }


    public function restore(Request $request)
    {
        $request->validate(['field' => 'required|exists:fields,id']);
        $field = Field::withTrashed()->findOrFail($request->input('field'));

        $field->restore();

        return redirect()->route('admin.field.show', $field)->with('success', __('basic.actions.recovered', ['name' => $this->getModelName()]));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Field $field)
    {
        $field->delete();
        return redirect()->route('admin.field.index')->with('success', __('basic.actions.deleted', ['name' => $this->getModelName()]));
    }

    public function delete(Request $request)
    {
        $request->validate(['field' => 'required|exists:fields,id']);
        $field = Field::withTrashed()->findOrFail($request->input('field'));

        $field->forceDelete();

        return redirect()->route('admin.field.index')->with('success', __('basic.actions.permanent_deleted', ['name' => $this->getModelName()]));
    }


    protected static function requiresPermission()
    {
        return true;
    }

    protected static function getPermissionKey()
    {
        return 'fields';
    }

    public static function getModelName()
    {
        return 'Field';
    }
}
