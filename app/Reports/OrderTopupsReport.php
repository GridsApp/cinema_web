<?php

namespace App\Reports;

use App\Models\Distributor;
use App\Models\OrderSeat;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use twa\cmsv2\Reports\DefaultReport;


class OrderTopupsReport extends DefaultReport
{

    public $label = "Order Topups";
    public $pagination = 100;


    public function filters()
    {
        $this->addFilter('filter_start_date');
        $this->addFilter('filter_end_date');
        $this->addFilter('filter_branch');

        $this->addFilter('filter_user_phone');
        $this->addFilter('filter_system');
        $this->addFilter('filter_payment_method');
        $this->addFilter('filter_pos_user');
        // $this->addFilter('filter_reference');

        $this->addFilter('filter_amount_min');
        $this->addFilter('filter_amount_max');
    }


    public function header()
    {
        if (!$this->filterResults) {
            return;
        }

        $this->addColumn("created_at", "Date");
        $this->addColumn("customer_name", "Customer");
        $this->addColumn("reference", "Reference");
        $this->addColumn("topup", "Top-up");
        $this->addColumn("unit_price", "Price");
        $this->addColumn("nb_topups", "Quantity");
        $this->addColumn("total_price", "Total Amount");
        $this->addColumn("branch", "Branch");
        $this->addColumn("booked_by", "Served By");
        $this->addColumn("system", "Via");
        $this->addColumn("payment_method", "Payment Method");
    }



    public function rows()
    {
        if (!$this->filterResults) {
            return [];
        }



        $dateRange = isset($this->filterResults['start_date'], $this->filterResults['end_date'])
            ? [Carbon::parse($this->filterResults['start_date'])->startOfDay(), Carbon::parse($this->filterResults['end_date'])->endOfDay()]
            : null;
        $footer = [
            'created_at' => 'Total',
            'customer_name' => '-',
            'reference' => '-',
            'topup' => '-',
            'unit_price' => '-',
            'nb_topups' => 0,
            'total_price' => 0,
            'branch' => '-',
            'booked_by' => '-',
            'system' => '-',
            'payment_method' => '-',
        ];




        $baseQuery = DB::table('order_topups')
            ->join('orders', 'order_topups.order_id', '=', 'orders.id')
            ->leftJoin('users as customers', 'orders.user_id', '=', 'customers.id')
            ->leftJoin('pos_users', 'orders.pos_user_id', '=', 'pos_users.id')
            ->leftJoin('branches', 'orders.branch_id', '=', 'branches.id')
            ->leftJoin('payment_methods', 'orders.payment_method_id', '=', 'payment_methods.id')
            ->leftJoin('systems', 'orders.system_id', '=', 'systems.id')
            ->select([
                'orders.id as order_id',
                'orders.reference',
                'orders.user_id',
                'customers.name as customer_name',
                'pos_users.name as booked_by',
                'orders.branch_id',
                'branches.label_en as branch',
                'branches.condensed_name as branch_condensed',
                'orders.payment_method_id',
                'payment_methods.label as payment_method',
                'order_topups.price as unit_price',
                'order_topups.label as topup',

                DB::raw('COUNT(*) as topups_count'),
                // DB::raw("GROUP_CONCAT(seat) as seats"),
                DB::raw("CONCAT(order_topups.order_id,'_',orders.reference) as computed_identifier"),
                'order_topups.created_at',
                'systems.label as system',
            ])

            ->whereNull('order_topups.deleted_at');

        if ($dateRange) {
            $baseQuery->whereBetween('order_topups.created_at', $dateRange);
        }

        if (!empty($this->filterResults['branch_id'])) {
            $baseQuery->where('orders.branch_id', $this->filterResults['branch_id']);
        }

        if (!empty($this->filterResults['pos_user_id'])) {
            $baseQuery->where('orders.pos_user_id', $this->filterResults['pos_user_id']);
        }

        if (!empty($this->filterResults['phone'])) {
            $baseQuery->where('customers.phone',  $this->filterResults['phone']);
        }

        if (!empty($this->filterResults['system_id'])) {
            $baseQuery->where('orders.system_id', $this->filterResults['system_id']);
        }

        if (!empty($this->filterResults['payment_method_id'])) {
            $baseQuery->where('orders.payment_method_id', $this->filterResults['payment_method_id']);
        }

        if (!empty($this->filterResults['reference'])) {
            $baseQuery->where('orders.reference', $this->filterResults['reference']);
        }

        if (!empty($this->filterResults['amount_min'])) {
            $baseQuery->havingRaw('SUM(order_topups.price) >= ?', [$this->filterResults['amount_min']]);
        }

        if (!empty($this->filterResults['amount_max'])) {
            $baseQuery->havingRaw('SUM(order_topups.price) <= ?', [$this->filterResults['amount_max']]);
        }
        $baseQuery->groupBy('computed_identifier');




        if($this->pagination){
            $results = $baseQuery->paginate($this->pagination);
        }else{

            $results = $baseQuery->get();
        }



        $fn=function ($row) use (&$footer) {

            $unit_price = $row->unit_price;
            $topups_count = $row->topups_count;
            $total_price = $unit_price * $topups_count;


            $data = [
                'created_at' => Carbon::parse($row->created_at)->format('d-m-Y H:i'),
                'customer_name' => $row->customer_name ?? '',
                'reference' => $row->reference,
                'unit_price' => number_format($unit_price),
                'nb_topups' => $topups_count,
                'total_price' => number_format($total_price),
                'topup' => $row->topup,
                'branch' => !empty($row->branch_condensed) ? $row->branch_condensed : $row->branch,
                'theater' => $row->theater ?? '-',
                'booked_by' => $row->booked_by ?? '-',
                'system' => $row->system ?? '-',
                'payment_method' => $row->payment_method ?? '-',
            ];
            $footer['nb_topups'] += $topups_count;
            $footer['total_price'] += $total_price;


            return $data;
        };
        // dd($results);
        if($this->pagination){
            $rows = $results->through($fn);
        }else{
            $rows = $results->map($fn);
        }


        $footer['nb_topups'] = $footer['nb_topups'];
        $footer['total_price'] = number_format($footer['total_price']);


        $this->setFooter($footer);

        return $rows;
    }


    public function footer()
    {
        $this->setFooter("id", 2);
        $this->setFooter("id", 2);
    }
}
