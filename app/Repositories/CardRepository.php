<?php

namespace App\Repositories;


use App\Interfaces\CardRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Models\UserCard;
use App\Models\UserLoyaltyTransaction;
use App\Models\UserWalletTransaction;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class CardRepository implements CardRepositoryInterface
{



    private UserRepositoryInterface $userRepository;




    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function createWalletTransaction($type, $amount, $user, $description, $reference = null, $gateway_reference = null, $operator_id = null, $operator_type = null)
    {

        if (!$operator_type || !$operator_id) {
            return false;
        }
        switch ($operator_type) {
            case "App\Models\PosUser":
                $system_id = 2;
                break;

            case "App\Models\User":
                $system_id = 1;
                break;

            case "twa\cmsv2\Models\CMSUser":
                $system_id = 5;
                break;
            default:
                break;
        }

        $active_card = $this->getActiveCard($user);
        if (!$active_card) {
            return false;
        }

        $lastTransaction = UserWalletTransaction::whereNull('deleted_at')
            ->where('user_id', $user->id)
            ->latest()
            ->first();

        $currentBalance = $lastTransaction->balance ?? 0;
        $multiplier = $type == "out" ? -1 : 1;
        $newBalance = $currentBalance + ($multiplier * $amount);


        if ($newBalance < 0) {
            return false;
        }
        $transaction = new UserWalletTransaction();
        $transaction->user_id = $user->id;
        $transaction->amount = $amount;
        $transaction->description = $description;
        $transaction->type = $type;
        $transaction->balance = $newBalance;
        $transaction->reference = $reference;
        $transaction->gateway_reference = $gateway_reference;
        $transaction->user_card_id = $active_card["id"];
        $transaction->transactionable_id = $operator_id;
        $transaction->transactionable_type = $operator_type;
        $transaction->system_id = $system_id;

        $transaction->save();
        return true;
    }
    public function createLoyaltyTransaction($type, $amount, $user, $description, $reference = null)
    {

        $active_card = $this->getActiveCard($user);

        if (!$active_card) {
            return false;
        }

        $lastTransaction = UserLoyaltyTransaction::whereNull('deleted_at')
            ->where('user_id', $user->id)
            ->latest()
            ->first();

        $currentBalance = $lastTransaction->balance ?? 0;

        $multiplier = $type == "out" ? -1 : 1;

        $newBalance = $currentBalance + ($multiplier * $amount);

        if ($newBalance < 0) {
            return false;
        }

        $transaction = new UserLoyaltyTransaction();
        $transaction->user_id = $user->id;
        $transaction->amount = $amount;
        $transaction->description = $description;
        $transaction->type = $type;
        $transaction->balance = $newBalance;
        $transaction->reference = $reference;
        $transaction->user_card_id = $active_card["id"];
        $transaction->save();

        return true;
    }
    public function createCard($user, $barcode = null, $type = 'digital')
    {

        try {
            DB::beginTransaction();

            UserCard::where('user_id', $user->id)->whereNull('disabled_at')->whereNull('deleted_at')->update([
                'disabled_at' => now()
            ]);

            $card = new UserCard;
            $card->user_id = $user->id;
            $card->barcode = !$barcode ? $this->generateBarcode() : $barcode;
            $card->type = $type;
            $card->save();

            DB::commit();

            return true;
        } catch (\Throwable $th) {
            DB::rollBack();

            return false;
        }
    }

    public function getLoyaltyBalance($user)
    {

        $transaction = UserLoyaltyTransaction::whereNull('deleted_at')
            ->where('user_id', $user->id)
            ->latest()->first();

        return $transaction->balance ?? 0;
    }

    public function getLoyaltyTransactions($user)
    {

        $loyalty_transactions = [];


        $transactions = UserLoyaltyTransaction::whereNull('deleted_at')
            ->where('user_id', $user->id)
            ->get();

        foreach ($transactions as $transaction) {
            $loyalty_transactions[] = [
                'id' => $transaction->id,
                'amount' => $transaction->amount,
                'type' => $transaction->type,
                'description' => $transaction->description,
            ];
        }

        return $loyalty_transactions;
    }


    public function getWalletBalance($user)
    {
        $transaction = UserWalletTransaction::whereNull('deleted_at')
            ->where('user_id', $user->id)
            ->latest()->first();

        return $transaction->balance ?? 0;
    }
    //nourhane
    public function getWalletTransactions($user)
    {
        $wallet_transactions = [];
        $transactions = UserWalletTransaction::whereNull('deleted_at')
            ->where('user_id', $user->id)
            ->get();

        foreach ($transactions as $transaction) {


            // dd($transaction->transactionable);
            $wallet_transactions[] = [
                'id' => $transaction->id,
                'amount' => $transaction->amount,
                'balance' => $transaction->balance,
                'type' => $transaction->type,
                'description' => $transaction->description,
                'date' => now()->parse($transaction->created_at)->format('d-m-Y H:i'),
                'reference' => "ORDER: " . $transaction->reference,
                'created_by' => $transaction->transactionable->name ?? "-",
                'system' => $transaction->system->label ?? "-"
            ];
        }


        return $wallet_transactions;
    }

    public function getActiveCard($user, $card = null)
    {


        $active_card = $card ? $card : $user->cards()
            ->whereNull('disabled_at')
            ->first();

        if (!$active_card) {
            return null;
        }

        // dd($active_card);

        $user_details = $this->userRepository->getUserById($active_card->user_id);


        if (!$user_details) {
            return null;
        }

        $wallet_balance = $this->getWalletBalance($user);
        $loyalty_balance = $this->getLoyaltyBalance($user);

        $card = [

            'user' => [
                'user_id' => $active_card->user_id,
                'name' => $user_details->name,
                'email' => $user_details->email,
                'phone' => $user_details->phone,
            ],
            'id' => $active_card->id,
            'barcode' => $active_card->barcode,
            'type' => $active_card->type,
            'wallet_balance' => currency_format($wallet_balance),
            'loyalty_points_balance' => [
                "value" => $loyalty_balance,
                "display" => $loyalty_balance . ' points'
            ],

        ];

        return $card;
    }


    public function getCardByBarcode($barcode)
    {
        try {

            $card = UserCard::where('barcode', $barcode)
                ->whereNull('disabled_at')
                ->whereNull('deleted_at')->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new Exception($e->getMessage());
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }


        return $card;
    }
    public function getCardByUserId($user_id)
    {
        try {
            $card = UserCard::where('user_id', $user_id)
                ->whereNull('disabled_at')
                ->whereNull('deleted_at')->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException("card of User ID {$user_id} not found .");
        }
        return $card;
    }


    public function checkIfBarcodeExists($barcode)
    {
        // dd("here");

        try {
            $user_card = UserCard::whereNull('deleted_at')->where('barcode', $barcode)->exists();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }


    public function updateUserCard($user_id, $updateData)
    {
        return  UserCard::whereNull('deleted_at')->where('user_id', $user_id)
            ->update($updateData);
    }
    public function generateBarcode()
    {
        do {
            $number = (string) rand(10000000000000000, 99999999999999999);
        } while (UserCard::where('barcode', $number)->whereNull('deleted_at')->first());

        return $number;
    }
}
