<?php

namespace App\Livewire\Components;

use App\Interfaces\CardRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use twa\uikit\Traits\ToastTrait;

class GetUser extends Component
{

    use ToastTrait;

    public $form = [];
    public $transactions = [];
    public $balance = 0;

    public $user;
    public $barcode = null;
    public $loyaltyBalance = 0;
    public $loyaltyTransactions = [];
    public $userCoupons = [];

    private CardRepositoryInterface $cardRepository;
    private UserRepositoryInterface $userRepository;

    public function __construct()
    {
        $this->cardRepository = app(CardRepositoryInterface::class);;
        $this->userRepository = app(UserRepositoryInterface::class);
    }


    public function mount()
    {

        $this->form['phone_email_card_number'] = null;
    }

    public function searchByCard()
    {
        $user = null;

        $this->validate([
            'form.phone_email_card_number' => 'required',

        ], [
            'form.phone_email_card_number' => 'Field is required',

        ]);


        $input = $this->form['phone_email_card_number'];
        if (str($input)->contains('@')) {
            $type = "email";
        } elseif (str($input)->contains('+')) {
            $type = "phone";
        } elseif (is_numeric($input) && strlen($input) < 10) {
            $type = "id";
        } else {
            $type = "card";
        }

        try {
            switch ($type) {
                case "email":
                    $user = $this->userRepository->getUserByEmail($this->form['phone_email_card_number'], true);
                    break;

                case "phone":
                    $user = $this->userRepository->getUserByPhone($this->form['phone_email_card_number'], true);
                    break;
                case "id":
                    $user = $this->userRepository->getUserById($input, true);
                    break;
                case "card":
                    $user = $this->userRepository->getUserByCardNumber($this->form['phone_email_card_number'], true);
                    break;
            }
        } catch (\Throwable $th) {
            $this->sendError("Error", "Please enter card number, phone, or email.");
            return;
        }

        if (!$user) {
            $this->sendError("Error", "Please enter card number, phone, or email.");
            return;
        }


        $card_number = $this->cardRepository->getCardByUserId($user->id);

        $this->barcode = $card_number['barcode'] ?? null;


        $this->transactions = $this->cardRepository->getWalletTransactions($user);
        $this->balance = collect($this->transactions)->last()['balance'] ?? 0;
        $this->user = $user;
        $this->loyaltyTransactions = $this->cardRepository->getLoyaltyTransactions($user);
        // dd($this->loyaltyTransactions);
        $this->loyaltyBalance =  collect($this->loyaltyTransactions)->last()['balance'] ?? 0;
    }


    public function render()
    {

        return view('components.form.get-user');
    }

    public function blockUser()
    {

        // dd($this->user);
        if (!$this->user) {
            $this->sendError("Error", "No user selected.");
            return;
        }

        try {

            $user = $this->user;
            $user->blocked_at = now();
            $user->save();
            // Refresh user data
            $this->user = $this->userRepository->getUserById($user->id, true);
            $this->sendSuccess("Success", "User has been blocked.");
        } catch (\Throwable $th) {
            $this->sendError("Error", "Failed to block user.");
        }
    }


    public function unblockUser()
    {


        if (!$this->user) {
            $this->sendError("Error", "No user selected.");
            return;
        }

        try {

            $user = $this->user;
            $user->blocked_at = null;
            $user->save();
            // Refresh user data
            $this->user = $this->userRepository->getUserById($user->id, true);
            $this->sendSuccess("Success", "User has been blocked.");
        } catch (\Throwable $th) {
            $this->sendError("Error", "Failed to block user.");
        }
    }

    public function getUserCoupons($userId)
    {
        $this->userCoupons = DB::table('coupons')
            ->join('order_coupons', 'coupons.id', '=', 'order_coupons.coupon_id')
            ->join('orders', 'orders.id', '=', 'order_coupons.order_id')
            ->where('orders.user_id', $userId)
            ->select(
                'coupons.label',
                'coupons.code',
                'coupons.discount_flat',
                'coupons.expires_at',
                'coupons.used_at',
                'order_coupons.amount',
                'orders.id as order_id'
            )
            ->orderByDesc('coupons.used_at')
            ->get()
            ->toArray();
    }
}
