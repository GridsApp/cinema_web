<?php

namespace App\Reports;

use App\Models\Distributor;
use App\Models\OrderSeat;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use twa\cmsv2\Reports\DefaultReport;


class WalletTopupsReport extends DefaultReport
{

    public $label = "Wallet Topups";
    public $pagination = 100;


    public function filters()
    {
        $this->addFilter('filter_start_date');
        $this->addFilter('filter_end_date');
        $this->addFilter('filter_system');
        $this->addFilter('filter_pos_user');
        $this->addFilter('filter_card_number');
        $this->addFilter('filter_branch');
    }


    public function header()
    {
        if (!$this->filterResults) {
            return;
        }

        $this->addColumn("long_id", "Transaction #");
        $this->addColumn("date", "Operation Date");
        $this->addColumn("payment_method", "Mode of payment");
        $this->addColumn("reference", "Reference");
        $this->addColumn("branch", "Branch");
        $this->addColumn("cashier", "Cashier");
        $this->addColumn("card_number", "Card Number");
        $this->addColumn("customer_name", "Client Name");
        $this->addColumn("amount", "Amount");
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
            'long_id' => 'Total',
            'date' => '-',
            'payment_method' => '-',
            'reference' => '-',
            'branch' => '-',
            'cashier' => '-',
            'card_number' => '-',
            'customer_name' => '-',
            'amount' => 0,
        ];

        $baseQuery = DB::table('order_topups')
            ->join('orders', 'order_topups.order_id', '=', 'orders.id')
            ->leftJoin('users as customers', 'orders.user_id', '=', 'customers.id')
            ->leftJoin('pos_users', 'orders.pos_user_id', '=', 'pos_users.id')
            ->leftJoin('branches', 'orders.branch_id', '=', 'branches.id')
            ->leftJoin('payment_methods', 'orders.payment_method_id', '=', 'payment_methods.id')
            ->leftJoin('systems', 'orders.system_id', '=', 'systems.id')
            ->leftJoin('user_cards', 'orders.user_id', '=', 'user_cards.user_id') // this is the join you're missing
            ->select([
                'orders.id as order_id',
                'orders.reference',
                'orders.long_id',
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
                DB::raw('SUM(price) as amount'),
                DB::raw("CONCAT(order_topups.order_id,'_',orders.reference) as computed_identifier"),
                'order_topups.created_at',
                'systems.label as system',
                'user_cards.barcode',
            ])
            ->whereNull('order_topups.deleted_at')
            ->groupBy('computed_identifier');

        if ($dateRange) {
            $baseQuery->whereBetween('order_topups.created_at', $dateRange);
        }


        if (!empty($this->filterResults['system_id'])) {
            $baseQuery->where('orders.system_id', $this->filterResults['system_id']);
        }

        if (!empty($this->filterResults['pos_user_id'])) {
            $baseQuery->where('orders.pos_user_id', $this->filterResults['pos_user_id']);
        }

        if (!empty($this->filterResults['card_number'])) {
            $baseQuery->where('user_cards.barcode', $this->filterResults['card_number']);
        }

        if (!empty($this->filterResults['branch_id'])) {
            $baseQuery->where('orders.branch_id', $this->filterResults['branch_id']);
        }


        $results = $baseQuery->get();



        $rows = $results->map(function ($row) use (&$footer) {
            $createdAt = Carbon::parse($row->created_at);

            $data = [
                'long_id' => $row->long_id,
                'date' =>  $createdAt->format('d-m-Y'),
                'payment_method' => $row->payment_method ?? '-',
                'reference' => $row->reference,
                'branch' => !empty($row->branch_condensed) ? $row->branch_condensed : $row->branch ?? '-',
                'cashier' => $row->booked_by ?? '-',
                'card_number' => $row->barcode ?? '',
                'customer_name' => $row->customer_name,
                'amount' => $row->amount,
            ];
            $footer['amount'] += $data['amount'];

            $data['amount'] = number_format($data['amount']);


            return $data;
        })->filter()->values();


        $footer['amount'] = number_format($footer['amount']);

        $this->setFooter($footer);

        return $rows;
    }


    public function footer()
    {
        $this->setFooter("id", 2);
        $this->setFooter("id", 2);
    }
}
