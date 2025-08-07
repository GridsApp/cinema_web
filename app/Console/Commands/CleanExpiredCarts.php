<?php

namespace App\Console\Commands;


use App\Models\Cart;
use App\Models\CartItem;
use App\Models\CartSeat;
use App\Models\CartTopup;
use App\Models\CartCoupon;
use App\Models\CartImtiyaz;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CleanExpiredCarts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'carts:clean-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete expired carts from the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        
        $expiredCartsIds = Cart::select('id')->where('expires_at', '<', now())->pluck('id');

        try {

            DB::beginTransaction();


            CartSeat::whereIn('cart_id', $expiredCartsIds)->delete();
            CartCoupon::whereIn('cart_id', $expiredCartsIds)->delete();
            CartImtiyaz::whereIn('cart_id', $expiredCartsIds)->delete();
            CartItem::whereIn('cart_id', $expiredCartsIds)->delete();
            CartTopup::whereIn('cart_id', $expiredCartsIds)->delete();

            Cart::whereIn('id', $expiredCartsIds)->delete();

            DB::commit();
            $this->info("Deleted expired carts and their related records.");
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->error("Not Deleted.");
        }
    }
}
