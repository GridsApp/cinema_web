<?php

namespace App\Reports;

use App\Models\Distributor;
use App\Models\OrderSeat;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use twa\cmsv2\Reports\DefaultReport;


class WalletCardsReport extends DefaultReport
{

    public $label = "Wallet Card";



    public function filters()
    {
        $this->addFilter('filter_start_date');
        $this->addFilter('filter_end_date');
        $this->addFilter('filter_wallet_status');
    }


    public function header()
    {
        if (!$this->filterResults) {
            return;
        }


        $this->addColumn("card_number", "Card Number");
        $this->addColumn("status", "Status");
        $this->addColumn("creation_date", "Creation Date");
        $this->addColumn("creation_time", "Creation Time");
        $this->addColumn("client_name", "Client Name");
        $this->addColumn("topup_amount", "Topup Amount");
        $this->addColumn("paid_amount", "Paid Amount");
        $this->addColumn("earned_points", "Earned Points");
        $this->addColumn("deducted_points", "Deducted points");
        $this->addColumn("wallet_amount", "End Balance Amount");
        $this->addColumn("loyalty_points", "End Balance Points");
    }



    public function rows()
    {
        if (!$this->filterResults) {
            return [];
        }

        $dateRange = isset($this->filterResults['start_date'], $this->filterResults['end_date'])
            ? [Carbon::parse($this->filterResults['start_date'])->startOfDay(), Carbon::parse($this->filterResults['end_date'])->endOfDay()]
            : null;

        $walletStatus = $this->filterResults['status'] ?? null;






        $footer = [
            'card_number' => 'Total',
            'status' => '-',
            'creation_date' => '-',
            'creation_time' => '-',
            'client_name' => '-',
            'topup_amount' => 0,
            'paid_amount' => 0,
            'earned_points' => 0,
            'deducted_points' => 0,
            'wallet_amount' => 0,
            'loyalty_points' => 0,
        ];

        $walletSub = DB::table('user_wallet_transactions')
            ->select(
                'user_card_id',
                DB::raw("SUM(CASE WHEN type = 'in' THEN amount ELSE 0 END) as topup_amount"),
                DB::raw("SUM(CASE WHEN type = 'out' THEN amount ELSE 0 END) as paid_amount"),
                DB::raw("SUM(CASE WHEN type = 'in' THEN amount ELSE 0 END) - SUM(CASE WHEN type = 'out' THEN amount ELSE 0 END) as wallet_amount")

            )
            ->groupBy('user_card_id');

        $loyaltySub = DB::table('user_loyalty_transactions')
            ->select(
                'user_card_id',
                DB::raw("SUM(CASE WHEN type = 'in' THEN amount ELSE 0 END) as earned_points"),
                DB::raw("SUM(CASE WHEN type = 'out' THEN amount ELSE 0 END) as deducted_points"),
                DB::raw("SUM(CASE WHEN type = 'in' THEN amount ELSE 0 END) - SUM(CASE WHEN type = 'out' THEN amount ELSE 0 END) as loyalty_points")
            )
            ->groupBy('user_card_id');

        $baseQuery = DB::table('user_cards')
            ->leftJoin('users as customers', 'user_cards.user_id', '=', 'customers.id')
            ->leftJoinSub($walletSub, 'wallets', 'wallets.user_card_id', '=', 'user_cards.id')
            ->leftJoinSub($loyaltySub, 'loyalties', 'loyalties.user_card_id', '=', 'user_cards.id')
            ->select([
                'user_cards.barcode as card_number',
                'customers.name as customer_name',
                DB::raw("COALESCE(wallets.topup_amount, 0) as topup_amount"),
                DB::raw("COALESCE(wallets.paid_amount, 0) as paid_amount"),
                DB::raw("COALESCE(wallets.wallet_amount, 0) as wallet_amount"),
                DB::raw("COALESCE(loyalties.earned_points, 0) as earned_points"),
                DB::raw("COALESCE(loyalties.deducted_points, 0) as deducted_points"),
                DB::raw("COALESCE(loyalties.loyalty_points, 0) as loyalty_points"),
                'user_cards.created_at',
                'user_cards.disabled_at',
                DB::raw("CONCAT(user_cards.id, '_', user_cards.barcode) as computed_identifier"),
            ])
            ->whereNull('user_cards.deleted_at')
            ->groupBy('user_cards.id', 'user_cards.barcode', 'customers.name', 'wallets.topup_amount', 'wallets.paid_amount', 'loyalties.earned_points', 'loyalties.deducted_points', 'user_cards.created_at');


        if ($dateRange) {
            // Add date range filter if both start and end dates are provided
            $baseQuery->whereBetween('user_cards.created_at', $dateRange);
        }

        if ($walletStatus) {
            if ($walletStatus == 'valid') {
                $baseQuery->whereNull('user_cards.disabled_at'); // Only valid cards (disabled_at is null)
            } elseif ($walletStatus == 'expired') {
                $baseQuery->whereNotNull('user_cards.disabled_at'); // Only expired cards (disabled_at is not null)
            }
        }
        $results = $baseQuery->get();

        $rows = $results->map(function ($row) use (&$footer) {
            $createdAt = Carbon::parse($row->created_at);
            $data = [
                'card_number' => $row->card_number,
                'status' => $row->disabled_at ? 'Expired' : 'Valid',

                'creation_date' => $createdAt->format('d-m-Y'),
                'creation_time' => $createdAt->format('H:i:s'),

                'client_name' => $row->customer_name,
                'topup_amount' => $row->topup_amount,
                'paid_amount' => $row->paid_amount,
                'earned_points' => $row->earned_points,
                'deducted_points' => $row->deducted_points,
                'wallet_amount' => $row->wallet_amount,
                'loyalty_points' => $row->loyalty_points,
            ];

            $footer['topup_amount'] += $data['topup_amount'];
            $footer['paid_amount'] += $data['paid_amount'];
            $footer['earned_points'] += $data['earned_points'];
            $footer['deducted_points'] += $data['deducted_points'];
            $footer['wallet_amount'] += $data['wallet_amount'];
            $footer['loyalty_points'] += $data['loyalty_points'];


            $data['topup_amount'] = number_format($data['topup_amount']);
            $data['paid_amount'] = number_format($data['paid_amount']);
            $data['earned_points'] = number_format($data['earned_points']);
            $data['deducted_points'] = number_format($data['deducted_points']);
            $data['wallet_amount'] = number_format($data['wallet_amount']);
            $data['loyalty_points'] = number_format($data['loyalty_points']);




            return $data;
        })->filter()->values();


        $footer['topup_amount'] = number_format($footer['topup_amount']);
        $footer['paid_amount'] = number_format($footer['paid_amount']);
        $footer['earned_points'] = number_format($footer['earned_points']);
        $footer['deducted_points'] = number_format($footer['deducted_points']);
        $footer['wallet_amount'] = number_format($footer['wallet_amount']);
        $footer['loyalty_points'] = number_format($footer['loyalty_points']);


        $this->setFooter($footer);

        return $rows;
    }


    public function footer()
    {
        $this->setFooter("id", 2);
        $this->setFooter("id", 2);
    }
}
