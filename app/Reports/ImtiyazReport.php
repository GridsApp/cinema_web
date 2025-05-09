<?php

namespace App\Reports;

use App\Models\Distributor;
use App\Models\OrderSeat;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use twa\cmsv2\Reports\DefaultReport;


class ImtiyazReport extends DefaultReport
{

    public $label = "Imtiyaz Report";



    public function filters()
    {

        $this->addFilter('filter_start_date');
        $this->addFilter('filter_end_date');
        $this->addFilter('filter_branch');
        $this->addFilter('filter_pos_user');
    }


    public function header()
    {
        if (!$this->filterResults) {
            return;
        }
        $this->addColumn("created_at" , "Created at");
        $this->addColumn("customer_name" , "Customer");
        $this->addColumn("reference" , "Reference");
        $this->addColumn("type" , "Type");
        $this->addColumn("unit_price" , "Price/Ticket");
        $this->addColumn("seat" , "Seat");
        $this->addColumn("imtiyaz_phone" , "Imtiyaz Phone");
        $this->addColumn("movie" , "Movie");
        $this->addColumn("date" , "Show Date");
        $this->addColumn("time" , "Show Time");
        $this->addColumn("branch" , "Branch");
        $this->addColumn("theater" , "Theater");
        $this->addColumn("booked_by" , "Booked By");
        $this->addColumn("system" , "Booked Via");
        $this->addColumn("payment_method" , "Payment Method");
    }




    public function rows()
    {
        if (!$this->filterResults) {
            return;
        }

        $start_date = $this->filterResults['start_date'] ?? null;
        $end_date = $this->filterResults['end_date'] ?? null;
        $branch = $this->filterResults['branch_id'] ?? null;
        $posUser = $this->filterResults['pos_user_id'] ?? null;

        $dateRange = ($start_date && $end_date)
    ? [Carbon::parse($start_date)->startOfDay(), Carbon::parse($end_date)->endOfDay()]
    : null;

        $footer = collect([
            'created_at' => '-',
            'customer_name' => '-',
            'reference' => '-',
            'type' => '-',
            'unit_price' => '-',
            'seat' => '-',
            'imtiyaz_phone' => '-',
            'movie' => '-',
            'date' => '-',
            'time' => '',
            'branch' => '-',
            'theater' => '-',
            'booked_by' => '-',
            'system' => '-',
            'payment_method' => '-',

        ]);


        // DB::table('orders' , )

        $ordersWithFreeSeats = DB::table('orders')
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                ->from('order_seats')
                ->whereColumn('order_seats.order_id', 'orders.id')
                ->whereNotNull('order_seats.imtiyaz_phone');
            })
        ->pluck('id');


        $query = DB::table('order_seats')
            ->join('orders', 'order_seats.order_id', '=', 'orders.id')
            
            ->leftJoin('movies', 'order_seats.movie_id', '=', 'movies.id')

            ->leftJoin('users as customers', 'orders.user_id', '=', 'customers.id')

            ->leftJoin('pos_users', 'orders.pos_user_id', '=', 'pos_users.id')
            ->leftJoin('branches', 'orders.branch_id', '=', 'branches.id')
            ->leftJoin('payment_methods', 'orders.payment_method_id', '=', 'payment_methods.id')
            ->leftJoin('systems', 'orders.system_id', '=', 'systems.id')
            ->leftJoin('times', 'order_seats.time_id', '=', 'times.id')
            ->leftJoin('theaters', 'order_seats.theater_id', '=', 'theaters.id')

            ->select([
                'orders.id as order_id',
                'orders.reference',
                'movies.name as movie',
                'movies.condensed_name as movie_condensed',
                'order_seats.label as type',
                'order_seats.seat as seat',
                'order_seats.imtiyaz_phone as imtiyaz_phone',
                'order_seats.date as date',
                'pos_users.name as booked_by',
                'branches.label_en as branch',
                'branches.condensed_name as branch_condensed',
                'payment_methods.label as payment_method',
                'customers.name as customer_name',
                'times.label as time',
                'theaters.label as theater',
                'order_seats.price as unit_price',
             
                'order_seats.created_at',
                'systems.label as system',
            ])
            ->whereIn('orders.id' , $ordersWithFreeSeats)
            ->whereNull('order_seats.deleted_at');
         
            if ($dateRange) {
                $query->whereBetween('order_seats.created_at', $dateRange);
            }
            
            if ($branch) {
                $query->where('orders.branch_id', $branch);
            }
            
            if ($posUser) {
                $query->where('orders.pos_user_id', $posUser);
            }
          
            $results = $query->get();


        $rows = $results->map(function ($row) use (&$footer) {
            $unit_price = $row->unit_price;
        
            $createdAt = Carbon::parse($row->created_at);


           


            $data = [


                'created_at' => $createdAt->format('d-m-Y'),
                'customer_name' => $row->customer_name ?? '-',
                'reference' => $row->reference,
                'type' => $row->type ?? '-',
                'unit_price' => '-' ,
                'seat' => $row->seat ?? '-',
                'imtiyaz_phone' => $row->imtiyaz_phone ?? '-',
                'movie' => !empty($row->movie_condensed) ? $row->movie_condensed : $row->movie,
                'date' => $row->date,
                'time' => $row->time ?? '-',
                'branch' =>!empty($row->branch_condensed) ? $row->branch_condensed : $row->branch,
                'theater' => $row->theater ?? '-',
                'booked_by' => $row->booked_by ?? '-',
                'system' => $row->system ?? '-',
                'payment_method' => $row->imtiyaz_phone ? 'Imtiyaz' : ($row->payment_method ?? '-'),


            ];


            // $footer['unit_price'] += $data['unit_price'];

            $data['unit_price'] = number_format($data['unit_price']);

            return $data;
        })->filter()->values();

        // $footer['unit_price'] = number_format($footer['unit_price']);


        $rows = $rows
    ->groupBy('reference')
    ->map(function ($group) {
        if($group->count() % 2 === 0){
            return $group; 
        }else{
            return $group->slice(0, -1)->values();
        }
    })
    ->flatten(1);


        $this->setFooter($footer);

        return $rows;
    }



    public function footer()
    {
        $this->setFooter("id", 2);
        $this->setFooter("id", 2);
    }
}
