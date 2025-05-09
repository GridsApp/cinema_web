<?php

namespace App\Reports;

use App\Models\Distributor;
use App\Models\OrderSeat;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use twa\cmsv2\Reports\DefaultReport;


class ErpCafeteriaReport extends DefaultReport
{

    public $label = "ERP Cafeteria Excel";



    public function filters()
    {

        $this->addFilter('filter_date');
        $this->addFilter('filter_date_type');
        $this->addFilter('filter_branch');
    }


    public function header()
    {
        if (!$this->filterResults) {
            return;
        }



        $this->addColumn("item_code", "Item Code");
        $this->addColumn("item_name", "Item Name");
        $this->addColumn("branch", "Branch");
        $this->addColumn("reference", "Order Number");
        $this->addColumn("booking_date", "Booking Date");
        $this->addColumn("booking_time", "Booking Time");
        $this->addColumn("unit_price", "Unit Price");
        $this->addColumn("quantity", "Qty");
        $this->addColumn("total_price", "Total Price");
        $this->addColumn("customer", "Customer");
        $this->addColumn("cashier", "Station");
        $this->addColumn("booked_via", "Booked Via");
        $this->addColumn("payment_method", "Payment Mode");
    }




    public function rows()
    {
        if (!$this->filterResults) {
            return;
        }

        $date = $this->filterResults['date'] ?? null;
        $date_type = $this->filterResults['date_type'] ?? 'range';
        $branch_id = $this->filterResults['branch_id'] ?? null;
        

        $dateRange = null;
        
        if ($date) {
            if ($date_type === 'single') {
                $start = Carbon::parse($date)->startOfDay();
                $end = Carbon::parse($date)->endOfDay();
            } else {
                $range = get_range_date($date);
                $start = $range['start']->startOfDay();
                $end = $range['end']->endOfDay();
            }
            $dateRange = [$start, $end];
        }
        

        $footer = collect([
            'item_code' => '-',
            'item_name' => '-',
            'branch' => '-',
            'reference' => '-',
            'booking_date' => '-',
            'booking_time' => '-',
            'unit_price' => '-',
            'quantity' => '-',
            'total_price' => 0,
            'customer' => '-',
            'cashier' => '-',
            'booked_via' => '-',
            'payment_method' => '-',
           
        ]);

        $results = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->leftJoin('users as customers', 'orders.user_id', '=', 'customers.id')
            ->leftJoin('pos_users', 'orders.pos_user_id', '=', 'pos_users.id')
            ->leftJoin('branches', 'orders.branch_id', '=', 'branches.id')
            ->leftJoin('payment_methods', 'orders.payment_method_id', '=', 'payment_methods.id')
         
            ->leftJoin('systems', 'orders.system_id', '=', 'systems.id')
           
            ->select([
                'orders.id as order_id',
                'orders.reference',
                'order_items.id',
                'orders.user_id',
                'customers.phone as customer_phone',
                'orders.pos_user_id',
                'pos_users.name as booked_by',
                'orders.branch_id',
                'branches.label_en as branch',
                'branches.condensed_name as branch_condensed',
                'orders.payment_method_id',
                'payment_methods.label as payment_method',
                'order_items.price as unit_price',
                DB::raw('COUNT(order_items.id) as items_count'),
               
            DB::raw("CONCAT(order_items.item_code,'_',orders.reference) as computed_identifier"),

                'order_items.label as item_name',
                'order_items.item_code as item_code',
               
                'order_items.created_at',
        
                'systems.label as system',
            ])
            ->when($dateRange, fn($q) => $q->whereBetween('order_items.created_at', $dateRange))
            ->when($branch_id, fn($q) => $q->where('orders.branch_id', $branch_id))
            ->whereNull('order_items.deleted_at')

            ->groupBy('computed_identifier')
            ->get();




        $rows = $results->map(function ($row) use (&$footer) {
            $unit_price = $row->unit_price;
            $items_count = $row->items_count;
            $total_price = $unit_price * $items_count;
           
            $createdAt = Carbon::parse($row->created_at);

            $data = [


                'item_code' => $row->item_code,
                'item_name' => $row->item_name,
                'branch' => !empty($row->branch_condensed) ? $row->branch_condensed : $row->branch,
                'reference' => $row->reference,
                'booking_date' => $createdAt->format('d-m-Y'),
                'booking_time' => $createdAt->format('H:i:s'),
                'unit_price' => $unit_price,
                'quantity' => $items_count,
                'total_price' => $total_price,
                'customer' => $row->customer_phone ?? '',
                'cashier' => $row->booked_by,
                'booked_via' => $row->system ?? '',
                'payment_method' => $row->payment_method ?? '',

               
            ];


            $footer['total_price'] += $data['total_price'];
       
            $data['total_price'] = number_format($data['total_price']);
       
            return $data;
        })->filter()->values();

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
