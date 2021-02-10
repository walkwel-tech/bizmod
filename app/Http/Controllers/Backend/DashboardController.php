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

        $codeClaimedWeekly = Code::ReportingDataWeekly()->claimed()->get();
        $codeWeekly = Code::ReportingDataWeekly()->get();
        $defaultStats = collect([
            'Sunday',
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday',
        ])
            ->mapWithKeys(function ($day) {
                $code = new Code();

                $code->records = 0;
                $code->dayname = $day;
                $code->claim = 0;

                return [$day => $code];
            });



        $codeWeeklyReport = $codeWeekly
            ->map(function ($code) use ($codeClaimedWeekly) {
                $codeclaimed = $codeClaimedWeekly
                    ->where('dayname', $code->dayname)
                    ->first();
                $code->claim = $codeclaimed ? $codeclaimed->records : 0;

                return $code;
            });

        $defaultStats->map(function ($s, $k) use ($codeWeeklyReport) {

            return $codeWeeklyReport->firstWhere('dayname', $k) ?? $s;
        })->values();

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

        $salesChartWeeklyData = [
            'labels' => $codeWeeklyReport->pluck('dayname'),
            'datasets' => [
                [
                    'label' => 'Claimed',
                    'data' => $codeWeeklyReport->pluck('claim'),
                ],
                [
                    'label' => 'Total',
                    'data' => $codeWeeklyReport->pluck('records'),
                ]
            ]
        ];

        return view('backend.dashboard', compact(['businessThisMonth', 'businessLastMonthAvg', 'clientThisMonth', 'clientLastMonthAvg', 'codeThisMonth', 'codeLastMonthAvg', 'codeThisMonthClaimed', 'codeLastMonthClaimedAvg', 'ordersChartData', 'salesChartData', 'salesChartWeeklyData']));
    }
}
