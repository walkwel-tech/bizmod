<?php

namespace App\Http\Controllers\Backend;

use App\Category;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use Spatie\QueryBuilder\QueryBuilder;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $allowedFilters = ['title'];

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $allowedFilters = $this->allowedFilters;

        $categories = QueryBuilder::for(Category::class)
            ->allowedFilters($allowedFilters)
            ->withCount(['services'])
            ->latest()
            ->paginate();

        $authKey = $this->getPermissionKey();
        $addNew = auth()->user()->can("backend.{$authKey}.create");

        return view('backend.category.index', compact(['allowedFilters', 'categories', 'addNew']));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
    */
    public function trashed(Request $request)
    {
        $allowedFilters = $this->allowedFilters;

        $categories = QueryBuilder::for(Category::class)
            ->onlyTrashed()
            ->allowedFilters($allowedFilters)
            // ->allowedIncludes(['tags'])
            // ->allowedAppends(['status'])
            // ->withDisabled()
            ->latest()
            ->paginate();

        $authKey = $this->getPermissionKey();
        $addNew = false; // auth()->user()->can("backend.{$authKey}.create");

        return view('backend.category.index', compact(['allowedFilters', 'categories', 'addNew']))
            ->with('pageHeader', 'Trashed');
    }    

    public function show(Request $request,  Category $category)
    {
        $form = [
            'title' => 'Update',
            'action' => 'edit',
            'action_route' => route('admin.category.update', $category),
            'passwords' => true,
            'method' => 'PATCH',
        ];

      

        return view('backend.category.single', compact(['category', 'form']));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request )
    {
        $category = new Category();

        $form = [
            'title' => 'Create',
            'action' => 'create',
            'passwords' => true,
            'action_route' => route('admin.category.store'),
            'method' => 'POST',
        ];


        return view('backend.category.single', compact(['category', 'form']));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Category $category)
    {
        return redirect()->route('admin.category.show', [$category]);
    }

    /**
     * @param \App\Http\Requests\CategoryStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryStoreRequest $request)
    {
        $category = Category::create($request->only([
            'title',
            'description'
        ]));


        return redirect()->route('admin.category.index');
    }

    /**
     * @param \App\Http\Requests\CategoryUpdateRequest $request
     * @param \App\Category $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $category->fill($request->only([
            'title',
            'description',
        ]));

        $category->save();


        return redirect()->route('admin.category.show', [$category])
            ->with('status', __('basic.actions.modified', ['name' => $this->getModelName()]));
    }


    public function restore(Request $request)
    {
        $request->validate(['category' => 'required|exists:categories,id']);
        $category = Category::withTrashed()->findOrFail($request->input('category'));

        $category->restore();

        return redirect()->route('admin.category.show', $category)->with('success', __('basic.actions.recovered', ['name' => $this->getModelName()]));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Category $category)
    {
        $category->delete();
        return redirect()->route('admin.category.index')->with('success', __('basic.actions.deleted', ['name' => $this->getModelName()]));
    }

    public function delete(Request $request)
    {
        $request->validate(['category' => 'required|exists:categories,id']);
        $category = Category::withTrashed()->findOrFail($request->input('category'));

        $category->forceDelete();

        return redirect()->route('admin.category.index')->with('success', __('basic.actions.permanent_deleted', ['name' => $this->getModelName()]));
    }


    protected static function requiresPermission ()
    {
        return true;
    }

    protected static function getPermissionKey()
    {
        return 'categories';
    }

    public static function getModelName ()
    {
        return 'Category';
    }
}
