<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Distributor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DistributorSharesController extends Controller
{
    public function render()
    {

        return view('pages.distributor-shares-report-filter');
    }


    public function result(Request $request)
    {

        $branchId = $request->input('branch_id');
        $date = $request->input('filter_datefi');
        $distributorId = $request->input('distributor_id');

        $dateRange = get_range_date($date);

        $branchLabel = 'ALL BRANCHES';
        if ($branchId) {
            $branch = Branch::where('id', $branchId)->whereNull('deleted_at')->first();
            $branchLabel = $branch?->label ?? 'Unknown Branch';
        }

        $distributor = Distributor::find($distributorId);
        $distributor_name = $distributor->label ?? "";

        $totals = [
            "movie" => "Totals",
            "admits" => 0,
            "gross_box_office" => 0,
            "tax" => 0,
            "net_box_office" => 0,
            "week" => "-",
            "percentage" => "-",
            "payable_film" => 0,
            "payable_film_calc" => 0,
        ];


        $query = DB::table('order_seats')
            ->join('movies', 'order_seats.movie_id', '=', 'movies.id')
            ->join('orders', 'order_seats.order_id', '=', 'orders.id')
            // ->leftJoin('distributors', 'movies.distributor_id', '=', 'distributors.id')
            ->whereNull('order_seats.refunded_at')
            ->when($branchId, function ($query, $branchId) {
                return $query->where('orders.branch_id', $branchId);
            })
            ->when($date, function ($query) use ($dateRange) {
                return $query->whereBetween('order_seats.date', $dateRange);
            })
            ->when($distributorId, function ($query, $distributorId) {
                return $query->where('movies.distributor_id', $distributorId);
            })
            ->select(
                // 'distributors.label as distributor_name',
                'movies.name as movie_name',
                DB::raw('COUNT(order_seats.id) as admits'),
                DB::raw('SUM(order_seats.price) as gross'),
                DB::raw('SUM(order_seats.price) * 0.05 as tax'),
                DB::raw('SUM(order_seats.price) - SUM(order_seats.price) * 0.05 as net'),

                'order_seats.week',
                'order_seats.dist_share_percentage',

                DB::raw('(SUM(order_seats.price) - SUM(order_seats.price) * 0.05) * (order_seats.dist_share_percentage / 100)  as calculated_share'),
                DB::raw('SUM(dist_share_amount) as share'),


                DB::raw("CONCAT(order_seats.movie_id,'_' , order_seats.week) as identifier")
            )
            ->groupBy('identifier')
            ->get()->map(function ($item) use (&$totals) {


                $totals['admits'] += $item->admits;
                $totals['gross_box_office'] += $item->gross;
                $totals['tax'] += $item->tax;
                $totals['net_box_office'] += $item->net;
                $totals['payable_film'] += $item->share;
                $totals['payable_film_calc'] += $item->calculated_share;




                return [
                    "movie" => $item->movie_name,
                    "admits" => number_format($item->admits),
                    "gross_box_office" => number_format($item->gross),
                    "tax" => $item->tax,
                    "net_box_office" => number_format($item->net),
                    "week" => $item->week,
                    "percentage" => $item->dist_share_percentage,
                    "payable_film" => number_format($item->share),
                    "payable_film_calc" => number_format($item->calculated_share),
                ];
            })->toArray();


        $totals['admits'] = number_format($totals['admits']);
        $totals['gross_box_office'] =   number_format($totals['gross_box_office']);
        $totals['tax'] =  number_format($totals['tax']);
        $totals['net_box_office'] =  number_format($totals['net_box_office']);
        $totals['payable_film'] =   number_format($totals['payable_film']);
        $totals['payable_film_calc'] =   number_format($totals['payable_film_calc']);


        $query[] = $totals;


        // ->whereNull('movie_shows.deleted_at')
        // ->get()->map(function ($item) use (&$totals) {

        //     $totals['sessions'] += $item->sessions;
        //     $totals['admits'] += $item->admits;
        //     $totals['gross'] += $item->gross;
        //     $totals['tax'] += $item->tax;
        //     $totals['net'] += $item->net;



        //     return [
        //         'movie_name' => $item->movie_name,
        //         'sessions' => number_format($item->sessions),
        //         'admits' => number_format($item->admits),
        //         'gross' => number_format($item->gross),
        //         'tax' => number_format($item->tax),
        //         'net' => number_format($item->net)
        //     ];
        // });




        // $baseQuery2 = DB::table('movie_shows')
        //     ->select(
        //         'movie_shows.date as show_date',

        //         'movie_shows.id as show_id',
        //         'order_seats.label as ticket',
        //         'order_seats.price as unit_price',
        //         'screen_types.label as screen',
        //         'times.label as show_time',
        //         'distributors.condensed_label as distributor_name',
        //         'movies.name as movie_name',
        //         'movies.id as movie_id',

        //         DB::raw('COUNT(DISTINCT order_seats.id) as admits'),
        //         DB::raw('SUM(order_seats.price) as gross'),
        //         DB::raw('SUM(order_seats.price)  * 0.05 as tax'),
        //         DB::raw('SUM(order_seats.price) + SUM(order_seats.price)  * 0.05 as net'),
        //         DB::raw("CONCAT(movie_shows.id,'_' , movie_shows.date) as identifier")

        //     )
        //     ->join('movies', 'movies.id', 'movie_shows.movie_id')
        //     ->leftJoin('order_seats', function ($join) {
        //         $join->on('order_seats.movie_show_id', '=', 'movie_shows.id');
        //         $join->whereNull('order_seats.refunded_at');
        //     })
        //     ->leftJoin('screen_types', 'movie_shows.screen_type_id', 'screen_types.id')
        //     ->leftJoin('times', 'movie_shows.time_id', 'times.id')
        //     ->leftJoin('distributors', 'movies.distributor_id', 'distributors.id')
        //     ->whereNull('movie_shows.deleted_at')

        //     ->groupBy('identifier')
        //     ->get();

        // // dd($baseQuery2);

        // $baseQuery2 = $baseQuery2->groupBy('movie_id');


        // $result = [];
        // // dd($baseQuery2);
        // foreach ($baseQuery2 as $movie_id => $shows) {

        //     $movie_totals = [
        //         'show_date' => 'Final Total',
        //         'screen' => '-',
        //         'show_time' => '-',
        //         'admits' => 0,
        //         'ticket' => '-',
        //         'unit_price' => 0,
        //         'gross' => 0,
        //         'tax' => 0,
        //         'net' => 0
        //     ];

        //     $showList = $shows->map(function ($show) use (&$movie_totals) {
        //         $movie_totals['admits'] += $show->admits;
        //         $movie_totals['unit_price'] += $show->unit_price;
        //         $movie_totals['gross'] += $show->gross;
        //         $movie_totals['tax'] += $show->tax;
        //         $movie_totals['net'] += $show->net;


        //         $show->show_date = $show->show_date . ' | ' . $show->show_id;

        //         return [
        //             'show_date' => $show->show_date,
        //             'screen' => $show->screen,
        //             'show_time' => $show->show_time,
        //             'ticket' => $show->ticket,
        //             'unit_price' => number_format($show->unit_price),
        //             'admits' => number_format($show->admits),
        //             'gross' => number_format($show->gross),
        //             'tax' => number_format($show->tax),
        //             'net' => number_format($show->net),
        //         ];
        //     });

        //     $result[] = [
        //         'dist' => $shows[0]->distributor_name ?? '',
        //         'movie' => $shows[0]->movie_name ?? '',
        //         'nb_shows' => $shows->count(),
        //         'shows' => $showList,
        //         'movie_totals' => $movie_totals
        //     ];
        // }


        return view('pages.distributor-shares-report-result', [
            'result' => $query,
            'distributor' => $distributor_name,
            'branch' =>  $branchLabel,
            'date' => $date,

        ]);
    }
}
