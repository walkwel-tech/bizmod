<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if (static::requiresPermission()) {
            $key = static::getPermissionKey();

            $this->middleware("permission:frontend.{$key}.read");//->only(['index']);
            $this->middleware("permission:frontend.{$key}.create")->only(['create', 'store']);
            $this->middleware("permission:frontend.{$key}.update")->only(['show', 'edit', 'update']);
            $this->middleware("permission:frontend.{$key}.delete")->only(['destroy', 'trashed', 'restore', 'delete']);
        }
    }

    protected static function requiresPermission ()
    {
        return false;
    }

    abstract protected static function getPermissionKey();
}
