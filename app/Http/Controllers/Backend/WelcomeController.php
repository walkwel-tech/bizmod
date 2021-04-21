<?php

namespace App\Http\Controllers\Backend;

use App\Page;


use Illuminate\Http\Request;


class WelcomeController extends Controller
{

    public function view(Request $request, Page $page)
    {

        return view('backend.page.view', compact(['page']));
    }


    protected static function requiresPermission ()
    {
        return false;
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
