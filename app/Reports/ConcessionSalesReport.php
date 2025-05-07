<?php

namespace App\Reports;

use App\Models\Distributor;
use App\Models\OrderSeat;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use twa\cmsv2\Reports\DefaultReport;


class ConcessionSalesReport extends DefaultReport
{

    public $label = "Concession Sales";
 


    public function filters()
    {
        $this->addFilter('filter_start_date');
        $this->addFilter('filter_end_date');
        $this->addFilter('filter_branch');
        $this->addFilter('filter_user_phone');
        $this->addFilter('filter_system');
        $this->addFilter('filter_payment_method');
        $this->addFilter('filter_reference');
    }


    public function header()
    {
        if (!$this->filterResults) {
            return;
        }

        $this->addColumn("created_at", "Date");
        $this->addColumn("reference", "Reference");
        $this->addColumn("item", "Extra");
        $this->addColumn("unit_price", "Price");
        $this->addColumn("nb_items", "Quantity");
        $this->addColumn("total_price", "Total Amount");
        $this->addColumn("branch", "branch");
        $this->addColumn("booked_by", "Served By");
        $this->addColumn("system", "Via");
        $this->addColumn("payment_method", "Payment Method");
        $this->addColumn("category", "Category");
        
    }



    public function rows()
    {if (!$this->filterResults) {
        return;
    }
    
    $dateRange = isset($this->filterResults['start_date'], $this->filterResults['end_date'])
        ? [Carbon::parse($this->filterResults['start_date'])->startOfDay(), Carbon::parse($this->filterResults['end_date'])->endOfDay()]
        : null;
    
    $footer = [
        'created_at' => 'Total',
        'reference' => '-',
        'item' => '-',
        'unit_price' => '-',
        'nb_items' => 0,
        'total_price' => 0,
        'branch' => '-',
        'booked_by' => '-',
        'system' => '-',
        'payment_method' => '-',
        'category' => '-',
    ];
    
    $baseQuery = DB::table('order_items')
        ->join('orders', 'order_items.order_id', '=', 'orders.id')
        ->leftJoin('users as customers', 'orders.user_id', '=', 'customers.id')

        ->leftJoin('pos_users', 'orders.pos_user_id', '=', 'pos_users.id')
        ->leftJoin('branches', 'orders.branch_id', '=', 'branches.id')
        ->leftJoin('payment_methods', 'orders.payment_method_id', '=', 'payment_methods.id')
        ->leftJoin('systems', 'orders.system_id', '=', 'systems.id')
        ->leftJoin('items', 'order_items.item_id', '=', 'items.id')
        ->select([
            'orders.id as order_id',
            'orders.reference',
            'orders.user_id',
            'pos_users.name as booked_by',
            'branches.label_en as branch',
            'orders.payment_method_id',
            'payment_methods.label as payment_method',
            'items.category as category',
            'order_items.price as unit_price',
            'order_items.label as item',
            DB::raw('COUNT(*) as items_count'),
            DB::raw("CONCAT(order_items.item_id,'_',orders.reference) as computed_identifier"),
            'order_items.created_at',
            'systems.label as system',
        ])
        ->whereNull('order_items.deleted_at')
        ->where('items.category', '=', 'glasses');
    
    if ($dateRange) {
        $baseQuery->whereBetween('order_items.created_at', $dateRange);
    }
    
    if (!empty($this->filterResults['branch_id'])) {
        $baseQuery->where('orders.branch_id', $this->filterResults['branch_id']);
    }
    
    if (!empty($this->filterResults['phone'])) {
        $baseQuery->where('customers.phone' , $this->filterResults['phone']);

    }
    
    if (!empty($this->filterResults['system_id'])) {
        $baseQuery->where('orders.system_id', $this->filterResults['system_id']);
    }
    
    if (!empty($this->filterResults['payment_method_id'])) {
        $baseQuery->where('orders.payment_method_id', $this->filterResults['payment_method_id']);
    }
    
    if (!empty($this->filterResults['reference'])) {
        $baseQuery->where('orders.reference',$this->filterResults['reference']);
    }
    
    $baseQuery->groupBy('computed_identifier');
    
    $results = $baseQuery->get();
    
    $rows = $results->map(function ($row) use (&$footer) {
        $unit_price = $row->unit_price;
        $items_count = $row->items_count;
        $total_price = $unit_price * $items_count;
    
        $data = [
            'created_at' => Carbon::parse($row->created_at)->format('d-m-Y H:i'),
            'reference' => $row->reference,
            'unit_price' => number_format($unit_price),
            'nb_items' => $items_count,
            'total_price' => number_format($total_price),
            'item' => $row->item,
            'branch' => $row->branch ?? '-',
            'booked_by' => $row->booked_by ?? '-',
            'system' => $row->system ?? '-',
            'payment_method' => $row->payment_method ?? '-',
            'category' => $row->category ?? '-',
        ];
    
        $footer['nb_items'] += $items_count;
        $footer['total_price'] += $total_price;
    
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
