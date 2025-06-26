<?php

namespace App\Reports;

use App\Models\Distributor;
use App\Models\OrderSeat;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use twa\cmsv2\Reports\DefaultReport;


class OrderCafeteriaReport extends DefaultReport
{

    public $label = "Order Cafeteria";
    // public $pagination = 100;


    public function filters()
    {
        $this->addFilter('filter_start_date');
        $this->addFilter('filter_end_date');
        $this->addFilter('filter_branch');
        $this->addFilter('filter_pos_user');
        $this->addFilter('filter_user_phone');
        $this->addFilter('filter_system');
        $this->addFilter('filter_payment_method');
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
        $this->addColumn("extra", "Extra");
        $this->addColumn("unit_price", "Price");
        $this->addColumn("nb_items", "Quantity");
        $this->addColumn("total_price", "Total Amount");
        $this->addColumn("branch", "Branch");
        $this->addColumn("booked_by", "Served By");
        $this->addColumn("system", "Via");
        $this->addColumn("payment_method", "Payment Method");
    }



    public function rows()
    {
        if (!$this->filterResults) {
            return;
        }



        $dateRange = isset($this->filterResults['start_date'], $this->filterResults['end_date'])
            ? [Carbon::parse($this->filterResults['start_date'])->startOfDay(), Carbon::parse($this->filterResults['end_date'])->endOfDay()]
            : null;


        $footer = [
            'created_at' => 'Total',
            'customer_name' => '-',
            'reference' => '-',
            'item' => '-',
            'unit_price' => '-',
            'nb_items' => 0,
            'total_price' => 0,
            'branch' => '-',
            'booked_by' => '-',
            'system' => '-',
            'payment_method' => '-',
        ];


        $baseQuery = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
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
                'order_items.price as unit_price',
                'order_items.label as extra',

                DB::raw('COUNT(*) as items_count'),
                // DB::raw("GROUP_CONCAT(seat) as seats"),
                DB::raw("CONCAT(order_items.item_id,'_',orders.reference) as computed_identifier"),
                'order_items.created_at',
                'systems.label as system',
            ])

            ->whereNull('order_items.deleted_at')
            ->groupBy('computed_identifier');
        $baseQuery
            ->when($dateRange, function ($query) use ($dateRange) {
                $query->whereBetween('order_items.created_at', $dateRange);
            })
            ->when(!empty($this->filterResults['branch_id']), function ($query) {
                $query->where('orders.branch_id', $this->filterResults['branch_id']);
            })
            ->when(!empty($this->filterResults['pos_user_id']), function ($query) {
                $query->where('orders.pos_user_id', $this->filterResults['pos_user_id']);
            })
            ->when(!empty($this->filterResults['phone']), function ($query) {
                $query->where('customers.phone' , $this->filterResults['phone']);
            })
            ->when(!empty($this->filterResults['system_id']), function ($query) {
                $query->where('orders.system_id', $this->filterResults['system_id']);
            })
            ->when(!empty($this->filterResults['payment_method_id']), function ($query) {
                $query->where('orders.payment_method_id', $this->filterResults['payment_method_id']);
            })
            ->when(!empty($this->filterResults['reference']), function ($query) {
                $query->where('orders.reference', $this->filterResults['reference']);
            })
            ->when(!empty($this->filterResults['amount_min']), function ($query) {
                $query->havingRaw('items_count * order_items.price >= ?', [$this->filterResults['amount_min']]);
            })
            ->when(!empty($this->filterResults['amount_max']), function ($query) {
                $query->havingRaw('items_count * order_items.price <= ?', [$this->filterResults['amount_max']]);
            });


        // $results = $baseQuery->get();
        if($this->pagination){
            $results = $baseQuery->paginate($this->pagination);
        }else{

            $results = $baseQuery->get();
        }

        $fn=function ($row) use (&$footer) {

            $unit_price = $row->unit_price;
            $items_count = $row->items_count;
            $total_price = $unit_price * $items_count;


            $data = [
                'created_at' => Carbon::parse($row->created_at)->format('d-m-Y H:i'),
                'customer_name' => $row->customer_name ?? '-',
                'reference' => $row->reference,
                'unit_price' => number_format($unit_price),
                'nb_items' => $items_count,
                'total_price' => number_format($total_price),
                'extra' => $row->extra,
                'branch' => !empty($row->branch_condensed) ? $row->branch_condensed : $row->branch,
                'theater' => $row->theater ?? '-',
                'booked_by' => $row->booked_by ?? '-',
                'system' => $row->system ?? '-',
                'payment_method' => $row->payment_method ?? '-',
            ];
            $footer['nb_items'] += $items_count;
            $footer['total_price'] += $total_price;


            return $data;
        };

        if($this->pagination){
            $rows = $results->through($fn);
        }else{
            $rows = $results->map($fn);
        }
     

        $footer['nb_items'] = $footer['nb_items'];
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
