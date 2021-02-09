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

        $codeClaimedData = Code::reportingData()->claimed()->get();
        $codeData = Code::reportingData()->get();
        $codeReport = $codeData->map(function ($code) use ($codeClaimedData) {

            $codeclaimed = $codeClaimedData->where('year', $code->year)->where('month', $code->month)->first();
            $code->claim = $codeclaimed ? $codeclaimed->records : 0;

            return $code;
        });
        $month = $claimedCode = $totalCode = array();

        foreach ($codeReport as $report) {
            $month[] = $report->month;
            $claimedCode[] = $report->claim;
            $totalCode[] = $report->records;
        }

        $ordersChartData = [
            'labels' => $month,
            "datasets" => [
                [
                    'label' => 'Claims',
                    'backgroundColor' => 'theme.primary',
                    'data' => $claimedCode
                ],
                [
                    'label' => 'Total',
                    'backgroundColor' => 'gray.400',
                    'data' => $totalCode
                ]
            ]
        ];

        $salesChartData = [
            'labels' => $month,
            'datasets' => [
                [
                    'label' => 'Performance',
                    'data' => $claimedCode
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

        return view('backend.dashboard', compact(['businessThisMonth', 'businessLastMonthAvg', 'clientThisMonth', 'clientLastMonthAvg', 'codeThisMonth', 'codeLastMonthAvg', 'codeThisMonthClaimed', 'codeLastMonthClaimedAvg', 'ordersChartData', 'salesChartData', 'salesChartWeeklyData']));
    }
}
