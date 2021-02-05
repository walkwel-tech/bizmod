<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Business;
use App\Client;
use App\Code;
use App\Http\Requests\ClientStoreRequest;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'permission:backend.access']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        ['current' => $businessThisMonth, 'average' => $businessLastMonthAvg] = Business::calculateCreationAverage();
        ['current' => $clientThisMonth, 'average' => $clientLastMonthAvg] = Client::calculateCreationAverage();

        ['current' => $codeThisMonthClaimed, 'average' => $codeLastMonthClaimedAvg] = Code::calculateCreationAverage(Code::claimed());
        ['current' => $codeThisMonth, 'average' => $codeLastMonthAvg] = Code::calculateCreationAverage(Code::unclaimed());

        return view('backend.dashboard', compact(['businessThisMonth', 'businessLastMonthAvg', 'clientThisMonth', 'clientLastMonthAvg', 'codeThisMonth','codeLastMonthAvg', 'codeThisMonthClaimed', 'codeLastMonthClaimedAvg']));
    }
}
