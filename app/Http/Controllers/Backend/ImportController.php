<?php

namespace App\Http\Controllers\Backend;


use App\Http\Requests\ImportStoreRequest;
use Spatie\QueryBuilder\QueryBuilder;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use Maatwebsite\Excel\Importer;
use App\Imports\ClientImport;
use App\Imports\UserImport;


class ImportController extends Controller
{
    protected $allowedFilters = ['title', 'prefix', 'owner.first_name'];
    private $importer;

    public function __construct(Importer $importer)
    {
        $this->importer = $importer;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $form = [
            'title' => 'Create',
            'action' => 'create',
            'passwords' => true,
            'action_route' => route('admin.import'),
            'method' => 'POST',
        ];

        return view('backend.import.single', compact(['form']));
    }

    /**
     * @param \App\Http\Requests\ProjectStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ImportStoreRequest $request)
    {

        switch ($request->input('import_type')) {
            case "client":
                $this->importer->import(new ClientImport, request()->file('import_file'));
                break;
            case "user":
                $this->importer->import(new UserImport, request()->file('import_file'));
                break;
            case "business":

                break;
            default:
        }
        return redirect()->route('admin.import')->with('success', __('basic.actions.saved', ['name' => $request->input('import_type')]));
    }



    protected static function requiresPermission()
    {
        return true;
    }

    protected static function getPermissionKey()
    {
        return 'import';
    }
}
