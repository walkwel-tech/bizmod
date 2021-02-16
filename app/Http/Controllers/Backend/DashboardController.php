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

        $codeClaimedDataYearly = Code::reportingDataYearly()->claimed()->get();
        $codeDataYearly = Code::reportingDataYearly()->get();
        $codeReportYearly = $codeDataYearly->map(function ($code) use ($codeClaimedDataYearly) {

            $codeclaimed = $codeClaimedDataYearly->where('year', $code->year)->where('year', $code->year)->first();
            $code->claim = $codeclaimed ? $codeclaimed->records : 0;

            return $code;
        });



        $businessReport = Business::select(['prefix'])->withCount(['codes as total_codes_count', 'codes as claimed_codes_count' => function ($query) {
            return $query->claimed();
        }])->get();


        $ordersChartData = [
            'labels' => $businessReport->pluck('prefix'),
            "datasets" => [
                [
                    'label' => 'Claims',
                    'backgroundColor' => 'theme.primary',
                    'data' => $businessReport->pluck('claimed_codes_count'),
                ],
                [
                    'label' => 'Total',
                    'backgroundColor' => 'gray.400',
                    'data' => $businessReport->pluck('total_codes_count'),
                ]
            ]
        ];

        $salesChartData = [
            'labels' =>  $codeReport->pluck('month'),
            'datasets' => [
                [
                    'label' => 'Claimed',
                    'borderColor' => 'theme.primary',
                    'data' => $codeReport->pluck('claim'),
                ],
                [
                    'label' => ['Total'],
                    'borderColor' => 'gray.400',
                    'data' =>  $codeReport->pluck('records')
                ]
            ]
        ];

        $salesChartYearlyData = [
            'labels' => $codeReportYearly->pluck('year'),
            'datasets' => [
                [
                    'label' => 'Claimed',
                    'borderColor' => 'theme.primary',
                    'data' => $codeReportYearly->pluck('claim'),
                ],
                [
                    'label' => 'Total',
                    'borderColor' => 'gray.400',
                    'data' => $codeReportYearly->pluck('records'),
                ]
            ]
        ];
// dump($ordersChartData);
// dump($salesChartData);
// dump($salesChartYearlyData);
        return view('backend.dashboard', compact(['businessThisMonth', 'businessLastMonthAvg', 'clientThisMonth', 'clientLastMonthAvg', 'codeThisMonth', 'codeLastMonthAvg', 'codeThisMonthClaimed', 'codeLastMonthClaimedAvg', 'ordersChartData', 'salesChartData', 'salesChartYearlyData']));
    }
}
