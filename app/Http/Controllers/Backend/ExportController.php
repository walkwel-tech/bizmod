<?php

namespace App\Http\Controllers\Backend;

use Spatie\QueryBuilder\QueryBuilder;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\Exports\ClientExport;
use App\Exports\BusinessExport;
use App\Exports\CodeExport;
use App\Exports\UserExport;
use Maatwebsite\Excel\Exporter;


class ExportController extends Controller
{
    protected $allowedFilters = ['title', 'prefix', 'owner.first_name'];
    private $exporter;

    public function __construct(Exporter $exporter)
    {
        $this->exporter = $exporter;
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
            'action_route' => route('admin.export'),
            'method' => 'POST',
        ];

        return view('backend.export.single', compact(['form']));
    }

    /**
     * @param \App\Http\Requests\ProjectStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        switch ($request->input('export_type')) {
            case "client":
                return $this->exporter->download(new ClientExport, 'client.csv');
                break;
            case "business":
                return $this->exporter->download(new BusinessExport, 'business.csv');
                break;
            case "user":
                return $this->exporter->download(new UserExport, 'user.csv');
                break;
            case "code":
                return $this->exporter->download(new CodeExport, 'code.csv');
                break;
            default:
                break;
        }
        return redirect()->route('admin.export');
    }



    protected static function requiresPermission()
    {
        return true;
    }

    protected static function getPermissionKey()
    {
        return 'export';
    }
}
