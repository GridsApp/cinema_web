<?php

namespace App\Livewire\Components;

use App\Interfaces\CardRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Models\Coupon;
use Livewire\Attributes\Url;
use Livewire\Component;
use twa\uikit\Traits\ToastTrait;
use Illuminate\Support\Facades\DB;

class ManageCoupons extends Component
{

    use ToastTrait;


    #[Url]
    public $form = [];

    public $transactions = [];
    public $editingCoupon = null;
   


    public function mount()
    {

        if (!empty($this->form['coupon_code'])) {
            $this->searchByCouponCode();
        }
        if(!isset($this->form['coupon_code'])){
            $this->form['coupon_code'] = '';
        }


    }

    public function searchByCouponCode()
    {

        // if (!cms_check_permission('view-transactions')) {
        //     $this->sendError("Permission Denied", "You do not have permission to view transactions.");
        //     return;
        // }

        $this->validate([
            'form.coupon_code' => 'required'
        ], ['form.coupon_code' => 'Coupon code is required']);

        $this->transactions = DB::table('coupons')
            ->leftJoin('orders', 'coupons.order_id', '=', 'orders.id')
            ->leftJoin('users', 'orders.user_id', '=', 'users.id')
            ->leftJoin('branches', 'orders.branch_id', '=', 'branches.id')
            ->leftJoin(DB::raw('(SELECT DISTINCT order_id, movie_id, theater_id, time_id FROM order_seats) as order_seats'), 'orders.id', '=', 'order_seats.order_id')
            ->leftJoin('movies', 'order_seats.movie_id', '=', 'movies.id')
            ->leftJoin('times', 'order_seats.time_id', '=', 'times.id')
            ->leftJoin('theaters', 'order_seats.theater_id', '=', 'theaters.id')
            ->leftJoin('pos_users as pos_users', 'orders.pos_user_id', '=', 'pos_users.id')

            ->where('coupons.code', $this->form['coupon_code'])
            ->select([
                'coupons.id',
                'coupons.label',
                'coupons.code',
                'coupons.used_at',
                'coupons.order_id',
                'coupons.expires_at',
                'orders.user_id',
                'orders.reference as order_reference',
                'orders.branch_id',
                'users.name as user_name',
                'users.id as user_id',
                'branches.label_en as branch_name',
                'movies.name as movie_name',
                'times.label as show_time',
                'theaters.label as theater',
                'orders.pos_user_id',
                'pos_users.name as pos_user_name',
                'orders.kiosk_user_id',
               
            ])
            ->distinct()
            ->get();
    }

 

    public function handleClear(){
        $this->form['coupon_code'] = null;
        $this->transactions = [];
    }

  


    public function render()
    {

      

        return view('components.form.manage-coupons');
    }
}
