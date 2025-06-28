<?php

namespace App\Reports;

use App\Models\Distributor;
use App\Models\OrderSeat;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use twa\cmsv2\Reports\DefaultReport;


class LoyaltyTransactionsReport extends DefaultReport
{

    public $label = "Loyalty Transactions";



    public function filters()
    {
        $this->addFilter('filter_start_date');
        $this->addFilter('filter_end_date');
        $this->addFilter('filter_user_phone');
        $this->addFilter('filter_user_email');
        $this->addFilter('filter_card_number');
     
    }


    public function header()
    {
        if (!$this->filterResults) {
            return;
        }

        $this->addColumn("long_id" , "Transaction ID");
        $this->addColumn("description" , "Description");
        $this->addColumn("type" , "Type");
        $this->addColumn("amount" , "Points");
        $this->addColumn("card_number" , "Card Number");
        $this->addColumn("client_name" , "Client Name");
        $this->addColumn("client_email" , "Client Email");
        $this->addColumn("client_phone" , "Client Phone");
        $this->addColumn("transaction_date" , "Creation Date");
        $this->addColumn("transaction_time" , "Creation Time");
        $this->addColumn("system" , "Via");

    }



    public function rows()
    {
        if (!$this->filterResults) {
            return [];
        }


        $dateRange = isset($this->filterResults['start_date'], $this->filterResults['end_date'])
        ? [
            Carbon::parse($this->filterResults['start_date'])->startOfDay(),
            Carbon::parse($this->filterResults['end_date'])->endOfDay()
        ]
        : null;



   
        $footer = [
            'long_id' => 'Total',
            'description' => '-',
            'card_number' => '-',
            'type' => '-',
            'amount' => 0,
            'client_name' => '-',
            'client_email' => '-',
            'client_phone' => '-',
            'transaction_date' => '-',
            'transaction_time' => '-',
            'system' => '-',
            'payment_method' => '-',
        ];



        $baseQuery = DB::table('user_loyalty_transactions')
            ->leftJoin('users as customers', 'user_loyalty_transactions.user_id', '=', 'customers.id')
            ->leftJoin('orders', 'user_loyalty_transactions.reference', '=', 'orders.id')
            ->leftJoin('payment_methods', 'orders.payment_method_id', '=', 'payment_methods.id')
            ->leftJoin('systems', 'orders.system_id', '=', 'systems.id')
            ->leftJoin('user_cards', 'user_loyalty_transactions.user_card_id', '=', 'user_cards.id')
            ->select([
                'user_cards.barcode as card_number',
                'customers.name as customer_name',
                'customers.email as customer_email',
                'customers.phone as customer_phone',

                'user_loyalty_transactions.created_at',
                'user_loyalty_transactions.long_id',
                'user_loyalty_transactions.description',
                'user_loyalty_transactions.type',
                'user_loyalty_transactions.amount',
                'systems.label as system',
                'payment_methods.label as payment_method',

            ])
            ->whereNull('user_cards.deleted_at');

            if ($dateRange) {
                $baseQuery->whereBetween('user_loyalty_transactions.created_at', $dateRange);
            }
        
            if (!empty($this->filterResults['phone'])) {
                $baseQuery->where('customers.phone',$this->filterResults['phone']);
            }
        
            if (!empty($this->filterResults['email'])) {
                $baseQuery->where('customers.email', $this->filterResults['email']);
            }
        
            if (!empty($this->filterResults['card_number'])) {
                $baseQuery->where('user_cards.barcode',$this->filterResults['card_number']);
            }

        $results = $baseQuery->get();

        $rows = $results->map(function ($row) use (&$footer) {
            $createdAt = Carbon::parse($row->created_at);

            $rawAmount = $row->amount;
            if ($row->type === 'out') {
                $rawAmount *= -1;
                // dd($rawAmount);

            }

            $data = [


                'long_id' => $row->long_id,
                'description' => $row->description ?? '-',
                'card_number' => $row->card_number ?? '-',

                'type' => $row->type ?? '-',
                'amount' => $rawAmount,
                'client_name' => $row->customer_name ?? '-',
                'client_email' => $row->customer_email ?? '-',
                'client_phone' => $row->customer_phone ?? '-',
                'transaction_date' => $createdAt->format('d-m-Y'),
                'transaction_time' => $createdAt->format('H:i:s'),
                'system' => $row->system ?? '-',
                'payment_method' => $row->payment_method ?? '-',
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
