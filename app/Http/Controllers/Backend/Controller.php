<?php

namespace App\Http\Controllers\Backend;

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

            $this->middleware("permission:backend.{$key}.read");//->only(['index']);
            $this->middleware("permission:backend.{$key}.create")->only(['create', 'store']);
            $this->middleware("permission:backend.{$key}.update")->only(['show', 'edit', 'update']);
            $this->middleware("permission:backend.{$key}.delete")->only(['destroy', 'trashed', 'restore', 'delete']);
        }
    }

    protected static function requiresPermission ()
    {
        return false;
    }

    abstract protected static function getPermissionKey();
}
