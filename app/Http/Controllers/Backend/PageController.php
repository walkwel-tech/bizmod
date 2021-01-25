<?php

namespace App\Http\Controllers\Backend;

use App\Page;
use App\Http\Requests\PageStoreRequest;
use App\Http\Requests\PageUpdateRequest;
use Spatie\QueryBuilder\QueryBuilder;

use Illuminate\Http\Request;


class PageController extends Controller
{
    protected $allowedFilters = ['title'];

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $allowedFilters = $this->allowedFilters;

        $pages = QueryBuilder::for(Page::class)
            ->allowedFilters($allowedFilters)
            ->latest()
            ->paginate();

        $authKey = $this->getPermissionKey();
        $addNew = auth()->user()->can("backend.{$authKey}.create");

        return view('backend.page.index', compact(['allowedFilters', 'pages', 'addNew']));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
    */
    public function trashed(Request $request)
    {
        $allowedFilters = $this->allowedFilters;

        $pages = QueryBuilder::for(Page::class)
            ->onlyTrashed()
            ->allowedFilters($allowedFilters)
            // ->allowedIncludes(['tags'])
            // ->allowedAppends(['status'])
            // ->withDisabled()
            ->latest()
            ->paginate();

        $authKey = $this->getPermissionKey();
        $addNew = false; // auth()->user()->can("backend.{$authKey}.create");

        return view('backend.project.index', compact(['allowedFilters', 'pages', 'addNew']))
            ->with('pageHeader', 'Trashed');
    }    

    public function show(Request $request,  Page $page)
    {
        $form = [
            'title' => 'Update',
            'action' => 'edit',
            'action_route' => route('admin.page.update', $page),
            'passwords' => true,
            'method' => 'PATCH',
        ];

      

        return view('backend.page.single', compact(['page', 'form']));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request )
    {
        $page = new Page();

        $form = [
            'title' => 'Create',
            'action' => 'create',
            'passwords' => true,
            'action_route' => route('admin.page.store'),
            'method' => 'POST',
        ];


        return view('backend.page.single', compact(['page', 'form']));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Page $page)
    {
        return redirect()->route('admin.page.show', [$page]);
    }

    /**
     * @param \App\Http\Requests\ProjectStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PageStoreRequest $request)
    {
        $page = Page::create($request->only([
            'title',
            'description'
        ]));


        return redirect()->route('admin.page.index');
    }

    /**
     * @param \App\Http\Requests\ProjectUpdateRequest $request
     * @param \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function update(PageUpdateRequest $request, Page $page)
    {
        $page->fill($request->only([
            'title',
            'description',
        ]));

        $page->save();


        return redirect()->route('admin.page.show', [$page])
            ->with('status', __('basic.actions.modified', ['name' => $this->getModelName()]));
    }


    public function restore(Request $request)
    {
        $request->validate(['page' => 'required|exists:pages,id']);
        $page = Page::withTrashed()->findOrFail($request->input('page'));

        $page->restore();

        return redirect()->route('admin.page.show', $page)->with('success', __('basic.actions.recovered', ['name' => $this->getModelName()]));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Page $page)
    {
        $page->delete();
        return redirect()->route('admin.page.index')->with('success', __('basic.actions.deleted', ['name' => $this->getModelName()]));
    }

    public function delete(Request $request)
    {
        $request->validate(['page' => 'required|exists:pages,id']);
        $page = Page::withTrashed()->findOrFail($request->input('page'));

        $page->forceDelete();

        return redirect()->route('admin.page.index')->with('success', __('basic.actions.permanent_deleted', ['name' => $this->getModelName()]));
    }


    protected static function requiresPermission ()
    {
        return true;
    }

    protected static function getPermissionKey()
    {
        return 'pages';
    }

    public static function getModelName ()
    {
        return 'Page';
    }
    
}
