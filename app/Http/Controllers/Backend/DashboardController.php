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


        $ordersChartData = [
            'labels' => ['Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            "datasets" => [
                    [
                        'label' => 'Claims',
                        'backgroundColor' => 'theme.primary',
                        'data' => [25, 72, 30, 22, 17, 80, 47, 14, 78, 10, 18, 85]
                    ],
                    [
                        'label' => 'Total',
                        'backgroundColor' => 'gray.400',
                        'data' => [250, 30, 74, 75, 48, 180, 80, 48, 200, 250, 180, 100]
                    ]
            ]
        ];

        $salesChartData = [
            'labels' => ['May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'datasets' => [
                [
                    'label' => 'Performance',
                    'data' => [0, 20, 10, 78, 15, 40, 20, 60, 60]
                ]
            ]
        ];

        $salesChartWeeklyData = [
            'labels' => ['May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'datasets' => [
                [
                    'label' => 'Performance',
                    'data' => [48, 20, 90, 60, 2, 78, 45, 80, 95]
                ]
            ]
        ];

        return view('backend.dashboard', compact(['businessThisMonth', 'businessLastMonthAvg', 'clientThisMonth', 'clientLastMonthAvg', 'codeThisMonth','codeLastMonthAvg', 'codeThisMonthClaimed', 'codeLastMonthClaimedAvg', 'ordersChartData', 'salesChartData', 'salesChartWeeklyData']));
    }
}
