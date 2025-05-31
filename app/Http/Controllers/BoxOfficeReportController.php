<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Distributor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use twa\uikit\Traits\ToastTrait;

class BoxOfficeReportController extends Controller
{



    public function render()
    {

        return view('pages.box-office-report-filter');
    }

    public function result(Request $request)
    {



        $branchId = $request->input('branch_id');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $distributorId = $request->input('distributor_id');



        $branchLabel = 'ALL BRANCHES';
        if ($branchId) {
            $branch = Branch::where('id', $branchId)->whereNull('deleted_at')->first();
            $branchLabel = $branch?->label ?? 'Unknown Branch';
        }


        $dist = Distributor::where('id', $distributorId)->whereNull('deleted_at')->first();

        $title = 'BOR_' . $branchLabel . '_' . ($dist->label ?? 'Unknown Distributor') . '_' . $start_date . '_00:00:00_' . $end_date . '_23:59:59';

        $totals = [
            'movie_name' => 'TOTALS',
            'sessions' => 0,
            'admits' => 0,
            'gross' => 0,
            'tax' => 0,
            'net' => 0
        ];

        $baseQuery = DB::table('movie_shows')
            ->select(
                'movies.name as movie_name',
                DB::raw('COUNT(DISTINCT movie_shows.id) as sessions'),
                DB::raw('COUNT(DISTINCT order_seats.id) as admits'),
                DB::raw('SUM(order_seats.price) as gross'),
                DB::raw('SUM(order_seats.price)  * 0.05 as tax'),
                DB::raw('SUM(order_seats.price) - SUM(order_seats.price)  * 0.05 as net')
            )
            ->join('movies', 'movies.id', 'movie_shows.movie_id')
            ->leftJoin('order_seats', function ($join) {
                $join->on('order_seats.movie_show_id', '=', 'movie_shows.id');
                $join->whereNull('order_seats.refunded_at');
            })
            ->leftJoin('orders', 'orders.id', '=', 'order_seats.order_id')
            ->groupBy('movies.id')

            // ->whereNull('movie_shows.deleted_at')
            ->when($distributorId, fn($q) => $q->where('movies.distributor_id', $distributorId))
            ->when($branchId, fn($q) => $q->where('orders.branch_id', $branchId))
            ->when($start_date, fn($q) => $q->whereDate('order_seats.date', '>=', $start_date))
            ->when($end_date, fn($q) => $q->whereDate('order_seats.date', '<=', $end_date))
            ->groupBy('movies.id')

            ->get()->map(function ($item) use (&$totals) {

                $totals['sessions'] += $item->sessions;
                $totals['admits'] += $item->admits;
                $totals['gross'] += $item->gross;
                $totals['tax'] += $item->tax;
                $totals['net'] += $item->net;


                return [
                    'movie_name' => $item->movie_name,
                    'sessions' => number_format($item->sessions),
                    'admits' => number_format($item->admits),
                    'gross' => number_format($item->gross),
                    'tax' => number_format($item->tax),
                    'net' => number_format($item->net)
                ];
            });




        $baseQuery2 = DB::table('movie_shows')
            ->select(
                'movie_shows.date as show_date',
                'movie_shows.id as show_id',
                'order_seats.label as ticket',
                'order_seats.price as unit_price',
                'screen_types.label as screen',
                'times.label as show_time',
                'distributors.condensed_label as distributor_name',
                'movies.name as movie_name',
                'movies.id as movie_id',

                DB::raw('COUNT(DISTINCT order_seats.id) as admits'),
                DB::raw('SUM(order_seats.price) as gross'),
                DB::raw('SUM(order_seats.price)  * 0.05 as tax'),
                DB::raw('SUM(order_seats.price) - SUM(order_seats.price)  * 0.05 as net'),
                DB::raw("CONCAT(movie_shows.id,'_' , movie_shows.date) as identifier")

            )
            ->join('movies', 'movies.id', 'movie_shows.movie_id')
            ->leftJoin('order_seats', function ($join) {
                $join->on('order_seats.movie_show_id', '=', 'movie_shows.id');
                $join->whereNull('order_seats.refunded_at');
            })
            ->leftJoin('orders', 'orders.id', '=', 'order_seats.order_id')
            ->leftJoin('screen_types', 'movie_shows.screen_type_id', 'screen_types.id')
            ->leftJoin('times', 'movie_shows.time_id', 'times.id')
            ->leftJoin('distributors', 'movies.distributor_id', 'distributors.id')
            // ->whereNull('movie_shows.deleted_at')
            ->when($distributorId, fn($q) => $q->where('movies.distributor_id', $distributorId))
            ->when($branchId, fn($q) => $q->where('orders.branch_id', $branchId))
            ->when($start_date, fn($q) => $q->whereDate('order_seats.date', '>=', $start_date))
            ->when($end_date, fn($q) => $q->whereDate('order_seats.date', '<=', $end_date))
            ->groupBy('identifier')
            ->get();



        $baseQuery2 = $baseQuery2->groupBy('movie_id');

        $result = [];
        // dd($baseQuery2);
        foreach ($baseQuery2 as $movie_id => $shows) {

            $movie_totals = [
                'show_date' => 'Final Total',
                'screen' => '-',
                'show_time' => '-',
                'admits' => 0,
                'ticket' => '-',
                'unit_price' => 0,
                'gross' => 0,
                'tax' => 0,
                'net' => 0
            ];

            $showList = $shows->map(function ($show) use (&$movie_totals) {
                $movie_totals['admits'] += $show->admits;
                $movie_totals['unit_price'] += $show->unit_price;
                $movie_totals['gross'] += $show->gross;
                $movie_totals['tax'] += $show->tax;
                $movie_totals['net'] += $show->net;


                $show->show_date = $show->show_date;

                return [
                    'show_date' => $show->show_date,
                    'screen' => $show->screen,
                    'show_time' => $show->show_time,
                    'ticket' => $show->ticket,
                    'unit_price' => number_format($show->unit_price),
                    'admits' => number_format($show->admits),
                    'gross' => number_format($show->gross),
                    'tax' => number_format($show->tax),
                    'net' => number_format($show->net),
                ];
            });

            $result[] = [
                'dist' => $shows[0]->distributor_name ?? '',
                'movie' => $shows[0]->movie_name ?? '',
                'nb_shows' => $shows->count(),
                'shows' => $showList,
                'movie_totals' => $movie_totals
            ];
        }


        return view('pages.box-office-result', [
            'mainResult' => $baseQuery,
            'detailedResult' => $result,
            'totals' => $totals,
            'branchLabel' => $branchLabel,
            'startDate' => $start_date,
            'endDate' => $end_date,
            'title' => $title
        ]);
    }


    public function renderSummary()
    {

        

        return view('pages.box-office-report-summary-filter');
    }

    public function renderSummaryResult(Request $request)
    {
        $branchId = $request->input('branch_id');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $distributorId = $request->input('distributor_id');



        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $branch = 'ALL BRANCHES';
        if ($branchId) {
            $branchModel = Branch::find($branchId);
            $branch = $branchModel?->label ?? 'Unknown Branch';
        }

        $dist = Distributor::where('id', $distributorId)->whereNull('deleted_at')->first();
        $title = 'BOR_SUMMARY_' . $branch . '_' . ($dist->label ?? 'Unknown Distributor') . '_' . $start_date . '_00:00:00_' . $end_date . '_23:59:59';


        $query = DB::table('order_seats')
            ->join('movies', 'order_seats.movie_id', '=', 'movies.id')
            ->leftJoin('distributors', 'movies.distributor_id', '=', 'distributors.id')
            ->join('orders', 'order_seats.order_id', '=', 'orders.id')
            ->whereNull('order_seats.refunded_at')
            ->select(
                'distributors.label as distributor_name',
                'movies.name as movie_name',
                DB::raw('COUNT(order_seats.id) as admits'),
                DB::raw('SUM(order_seats.price) as gross'),
                DB::raw('SUM(order_seats.price) * 0.05 as tax'),
                DB::raw('SUM(order_seats.price) - SUM(order_seats.price) * 0.05 as net')
            );

        if ($start_date) {
            $query->whereDate('order_seats.date', '>=', $start_date);
        }

        if ($end_date) {
            $query->whereDate('order_seats.date', '<=', $end_date);
        }

        if ($distributorId) {
            $query->where('movies.distributor_id', $distributorId);
        }
        if ($branchId) {
            $query->where('orders.branch_id', $branchId);
        }

        $movies = $query
            ->groupBy('movies.id', 'distributors.id')
            ->get();


        $grouped = $movies->groupBy('distributor_name');

        $results = [];

        foreach ($grouped as $distributor => $items) {
            $data = [];
            $totals = [
                'movie' => 'TOTALS',
                'admits_excluding_comps' => 0,
                'gbo_excluding_comps' => 0,
                'comps' => 0,
                'admits_including_comps' => 0,
                'gbo_including_comps' => 0,
                'gbo_tax_amount' => 0,
                'gbo_net_amount' => 0,
            ];

            foreach ($items as $item) {
                $data[] = [
                    'movie' => $item->movie_name,
                    'admits_excluding_comps' => number_format($item->admits),
                    'gbo_excluding_comps' => number_format($item->gross),
                    'comps' => '0',
                    'admits_including_comps' => number_format($item->admits),
                    'gbo_including_comps' => number_format($item->gross),
                    'gbo_tax_amount' => number_format($item->tax),
                    'gbo_net_amount' => number_format($item->net),
                ];

                $totals['admits_excluding_comps'] += $item->admits;
                $totals['gbo_excluding_comps'] += $item->gross;
                $totals['admits_including_comps'] += $item->admits;
                $totals['gbo_including_comps'] += $item->gross;
                $totals['gbo_tax_amount'] += $item->tax;
                $totals['gbo_net_amount'] += $item->net;
            }


            $totals = array_map(function ($value) {
                return is_numeric($value) ? number_format($value) : $value;
            }, $totals);

            $results[$distributor ?? 'Unknown Distributor'] = [$data, $totals];
        }

        return view('pages.box-office-summary-result', [
            'results' => $results,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'branch' => $branch,
            'title' => $title
        ]);
    }
}
