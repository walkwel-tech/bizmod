<?php

namespace App\Http\Controllers\Backend;


use App\Http\Requests\ImportStoreRequest;
use Spatie\QueryBuilder\QueryBuilder;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use Maatwebsite\Excel\Importer;
use App\Imports\ClientImport;

class ImportController extends Controller
{
    protected $allowedFilters = ['title','prefix','owner.first_name'];
    private $importer;

    public function __construct(Importer $importer)
    {
        $this->importer = $importer;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request )
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

        if($request->input('import_type') == 'client')
        {
            $this->importer->import(new ClientImport, request()->file('import_file'));
        }

    }



    protected static function requiresPermission ()
    {
        return true;
    }

    protected static function getPermissionKey()
    {
        return 'import';
    }



}
