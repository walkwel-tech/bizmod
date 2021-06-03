<?php

namespace App\Http\Controllers\Backend;


use App\Http\Requests\ImportStoreRequest;
use Spatie\QueryBuilder\QueryBuilder;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use Maatwebsite\Excel\Importer;
use App\Imports\ClientImport;
use App\Imports\UserImport;
use App\Imports\BusinessImport;
use App\Imports\CodeImport;
use App\Imports\CodeImportNew;
use Illuminate\Support\Facades\DB;


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
        $errorCode = Session::get('errorCode');
        if( $errorCode)
        {
            $request->session()->flash('status', '<strong>Error codes: </strong>'.implode(", ", $errorCode));
        }
        $request->session()->forget('errorCode');

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
                set_time_limit(0);
                $this->importer->import(new ClientImport, request()->file('import_file'));
                break;
            case "user":
                set_time_limit(0);
                $this->importer->import(new UserImport, request()->file('import_file'));
                break;
            case "business":
                set_time_limit(0);
                $this->importer->import(new BusinessImport, request()->file('import_file'));
                break;
            case "code":
                set_time_limit(0);
                $this->importer->import(new CodeImport, request()->file('import_file'));
                break;
            default:
            break;
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
