<?php

namespace App\Http\Controllers\Frontend;


use App\Project;

use Illuminate\Http\Request;


class ProjectController extends Controller
{
    protected $allowedFilters = ['title'];

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $projects = $user->projects()
            ->with('addresses')
            ->latest()
            ->paginate();

        return view('frontend.project.index', compact(['user', 'projects']));
    }


    public function show(Request $request, Project $project)
    {
        $user = $request->user();

        return view('frontend.project.single', compact(['user', 'project']));
    }

    protected static function requiresPermission ()
    {
        return true;
    }

    protected static function getPermissionKey ()
    {
        return 'projects';
    }
}
