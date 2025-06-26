<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cart;
use Carbon\Carbon;

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
        $expiredCarts = \App\Models\Cart::where('expires_at', '<', now())->get();
        $count = 0;
    
        foreach ($expiredCarts as $cart) {
           
            $cart->seats()->delete();
            $cart->coupons()->delete();
            $cart->imtiyaz()->delete();
            $cart->items()->delete();
            $cart->topups()->delete();
    
          
            $cart->delete();
            $count++;
        }
    
        $this->info("Deleted $count expired carts and their related records.");
    }
}
