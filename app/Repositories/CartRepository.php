<?php

namespace App\Repositories;


use App\Interfaces\CartRepositoryInterface;
use App\Interfaces\CouponRepositoryInterface;
use App\Interfaces\ItemRepositoryInterface;
use App\Interfaces\PriceGroupZoneRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\ZoneRepositoryInterface;
use App\Models\Coupon;
use App\Models\System;
use App\Models\UserCard;
use App\Models\Cart;
use App\Models\CartCoupon;
use App\Models\CartImtiyaz;
use App\Models\CartItem;
use App\Models\CartSeat;
use App\Models\CartTopup;
use App\Models\OrderSeat;
use App\Models\ReservedSeat;
use App\Models\Reward;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class CartRepository implements CartRepositoryInterface
{
    private ItemRepositoryInterface $itemRepository;
    private ZoneRepositoryInterface $zoneRepository;
    private UserRepositoryInterface $userRepository;
    private PriceGroupZoneRepositoryInterface $priceGroupZoneRepository;
    private CouponRepositoryInterface $couponRepository;



    public function __construct(ItemRepositoryInterface $itemRepository, ZoneRepositoryInterface $zoneRepository, UserRepositoryInterface $userRepository, PriceGroupZoneRepositoryInterface $priceGroupZoneRepository, CouponRepositoryInterface $couponRepository)
    {
        $this->itemRepository = $itemRepository;
        $this->zoneRepository = $zoneRepository;
        $this->userRepository = $userRepository;
        $this->priceGroupZoneRepository = $priceGroupZoneRepository;
        $this->couponRepository = $couponRepository;
    }


    public function checkCart($cart_id, $user_id, $user_type)
    {
        try {

            $field = get_user_field_from_type($user_type);

            $user_cart = Cart::where('id', $cart_id)
                ->where($field, $user_id)
                ->where('expires_at', '>', now())
                ->whereNull('deleted_at')
                ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e->getMessage());
        }

        return $user_cart;
    }
    public function getCartById($cart_id)
    {

    // dd($cart_id);

        try {
            $user_cart = Cart::where('id', $cart_id)
                ->where('expires_at', '>', now())->whereNull('deleted_at')->firstOrFail();

                // dd($user_cart);
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException("Cart with ID {$cart_id} not found or expired.");
        }
        // dd($user_cart);
        return $user_cart;
    }
    public function createCart($user_id, $user_type, $system_id)
    {
        $minutes = (int) get_setting('timer_reset_card') ?? 1;


        // dd(get_setting('timer_reset_card'));
        try {


            $field = get_user_field_from_type($user_type);
           

            $cart = new Cart();
            $cart->{$field} = $user_id;
            $cart->system_id = $system_id;
            $cart->expires_at = now()->addMinutes($minutes);
            $cart->save();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        return $cart;
    }
    public function expireCart($cart_id)
    {
        try {
            DB::beginTransaction();
            $cart =   $this->getCartById($cart_id);
            CartSeat::where('cart_id', $cart_id)->delete();
            CartItem::where('cart_id', $cart_id)->delete();
            CartTopup::where('cart_id', $cart_id)->delete();
            $cart->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
    public function addSeatToCart($cart_id, $seat, $movie_show, $zone_id)
    {

        // dd($zone_id, $movie_show->date , $movie_show->time->label);

        try {

            $price = $this->priceGroupZoneRepository->getPriceByZonePerDate($zone_id, $movie_show->date , "12:00");

            $cart_seat = new CartSeat();
            $cart_seat->seat = $seat;
            $cart_seat->cart_id = $cart_id;
            $cart_seat->zone_id = $zone_id;
            $cart_seat->movie_show_id = $movie_show->id;
            $cart_seat->movie_id = $movie_show->movie_id;
            $cart_seat->date = $movie_show->date;
            $cart_seat->week = $movie_show->week;
            $cart_seat->screen_type_id = $movie_show->screen_type_id;
            $cart_seat->theater_id = $movie_show->theater_id;
            $cart_seat->time_id = $movie_show->time_id;
            $cart_seat->price = $price;
            // $cart_seat->final_price = $price;
            // $cart_seat->discount = 0;
            $cart_seat->save();

     
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    
        return $cart_seat;
    }
    public function removeSeatFromCart($cart_id, $seat, $movie_show_id)
    {
        // dd($cart_id,$seat,$movie_show_id);

        try {
            $cart_seat = CartSeat::where('cart_id', $cart_id)
                ->where('seat', $seat)
                ->where('movie_show_id', $movie_show_id)->firstOrFail();
            $cart_seat->delete();

            // dd($cart_seat);
        } catch (ModelNotFoundException $e) {
            throw new Exception($e->getMessage());
        } catch (Exception $e) {

            throw new Exception($e->getMessage());
        }
    }
    public function addItemToCart($cart_id, $item_id)
    {

        // $price = $this->priceGroupZoneRepository->getPriceByZonePerDate($zone_id, $movie_show->date);
        $item = $this->itemRepository->getItemById($item_id);
        try {
            $cart_item = new CartItem();
            $cart_item->branch_item_id = $item_id;
            $cart_item->cart_id = $cart_id;
            $cart_item->price = $item->price;
            $cart_item->save();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return $cart_item;
    }
    public function removeItemFromCart($cart_id, $item_id)
    {

        try {
            $cart_item = CartItem::where('cart_id', $cart_id)->where('branch_item_id', $item_id)->orderBy('id', 'desc')->firstOrFail();


            $cart_item->delete();
        } catch (ModelNotFoundException $e) {
            throw new Exception($e->getMessage());
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    public function addTopupToCart($cart_id, $amount)
    {
        try {
            $cart_topup = new CartTopup();
            $cart_topup->amount = $amount;
            $cart_topup->label = 'Topup Amount';
            $cart_topup->cart_id = $cart_id;
            $cart_topup->save();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return $cart_topup;
    }
    public function removeTopupFromCart($cart_id)
    {
        try {
            $cart_topup = CartTopup::where('cart_id', $cart_id)->firstOrfail();
            $cart_topup->delete();
        } catch (ModelNotFoundException $e) {
            throw new Exception($e->getMessage());
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    public function addCardNumberToCart($cart_id, $card_number)
    {
        try {
            $cart = $this->getCartById($cart_id);

            $cart->card_number = $card_number;
            $cart->save();
        } catch (ModelNotFoundException $e) {
            throw new Exception($e->getMessage());
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return $cart;
    }

    public function addUserRewardIdToCart($cart_id, $user_reward)
    {
        // try {

        //     DB::beginTransaction();

        //     $cart = $this->getCartById($cart_id);

            // $reward = Reward::findOrFail($user_reward->reward_id);

            
            // $cart_seats = CartSeat::where('cart_id' , $cart_id)->whereNull('deleted_at')->get();
            // $cart_items = CartItem::where('cart_id' , $cart_id)->whereNull('deleted_at')->get();

            // $zones = $reward->zones;
            // $items = $reward->items;

            // foreach($cart_seats as $cart_seat){
            //     if($cart_seat->)
            // }

            // foreach($cart_seats as $cart_seat){
                
            // }

           
            
            // foreach($items as $item){

            // }
            


        //     $cart->user_reward_id = $user_reward->id;
        //     $cart->save();






        //     DB::commit();
        // } catch (ModelNotFoundException $e) {
        //     DB::rollBack();
        //     throw new Exception($e->getMessage());
        // } catch (Exception $e) {
        //     DB::rollBack();
        //     throw new Exception($e->getMessage());
        // }

        // return $cart;
    }

    
    public function removeCardNumberFromCart($cart_id)
    {
        try {
            $cart = $this->getCartById($cart_id);
            $cart->card_number = null;
            $cart->save();
        } catch (ModelNotFoundException $e) {
            throw new Exception($e->getMessage());
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    public function getReservedSeats($movie_show_id)
    {

        $cart_seats = CartSeat::whereNull('cart_seats.deleted_at')
            ->where('cart_seats.movie_show_id', $movie_show_id)
            ->join('carts', function($q){
            //    $q->on('cart_seats.cart_id', '=', 'carts.id');
               $q->where('carts.expires_at', '>', now());
            })
            ->pluck('seat');

        $reserved_seats = ReservedSeat::whereNull('deleted_at')
            ->where('movie_show_id', $movie_show_id)->pluck('seat');

        $booked = collect([]);
        $booked = $booked->merge($cart_seats)->merge($reserved_seats)->unique()->values()->toArray();
        return $booked;
    }
    public function getCartSeats($cart_id, $grouped = false)
    {

        $select = $grouped ? [DB::raw("CONCAT(COALESCE(zone_id,'0') ,'_', COALESCE(movie_show_id, '0') , '_' , COALESCE(imtiyaz_phone , '0') ) as identifier"), 'cart_id', 'zone_id', 'movie_show_id', 'price',  'imtiyaz_phone', DB::raw('count(*) as quantity')] : "*";

        try {

            $user_cart_seat = CartSeat::select($select)->whereNull('deleted_at')
                ->where('cart_id', $cart_id)
                ->when($grouped, function ($query) {
                    $query->groupBy('identifier');
                })
                ->orderBy('price', 'DESC')
                ->get();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return $user_cart_seat;
    }
    public function getCartItems($cart_id, $grouped = false)
    {

        $select = $grouped ? [DB::raw("CONCAT(COALESCE(item_id, '0'), '') as concatenated_item_id"), 'cart_id', 'item_id', DB::raw('count(*) as quantity')] : "*";

        try {
            $user_cart_item = CartItem::select($select)->whereNull('deleted_at')
                ->where('cart_id', $cart_id)
                ->when($grouped, function ($query) {
                    $query->groupBy('item_id');
                })
                ->get();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        return $user_cart_item;
    }
    public function getCartTopups($cart_id, $grouped = false)
    {

        $select = $grouped ? ['cart_id', 'amount', 'label', DB::raw('count(*) as quantity')] : "*";

        try {
            $user_cart_topup = CartTopup::select($select)

                ->whereNull('deleted_at')
                ->where('cart_id', $cart_id)
                ->when($grouped, function ($query) {
                    $query->groupBy('amount');
                })
                ->get();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return $user_cart_topup;
    }
    public function getCartCoupons($cart_id)
    {
        try {
            return CartCoupon::whereNull('deleted_at')->where('cart_id', $cart_id)->get();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }


    public function getCartImtiyaz($cart_id){
        try {
            return CartImtiyaz::whereNull('deleted_at')->where('cart_id', $cart_id)->get();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

    }



    public function getCartCouponsIds($cart_id)
    {
        try {
            return  CartCoupon::whereNull('deleted_at')->where('cart_id', $cart_id)->pluck('coupon_id');
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }


    public function addImtiyazToCart($cart_id, $phone)
    {
        try {
            $cart_imtiyaz = new CartImtiyaz();
            $cart_imtiyaz->phone = $phone;
            $cart_imtiyaz->cart_id = $cart_id;
            $cart_imtiyaz->save();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return $cart_imtiyaz;
    }
    public function removeImtiyazFromCart($cart_id , $phone)
    {
        try {

          

            $cart_imtiyaz =  CartImtiyaz::query()
                ->where('cart_id', $cart_id)
                ->where('phone' , $phone)
                ->whereNull('deleted_at');

            if ($cart_imtiyaz->count() > 0) {

                DB::beginTransaction();

                $cart_imtiyaz->delete();

                // CartSeat::query()
                //     ->where('cart_id', $cart_id)
                //     ->whereNull('deleted_at')
                //     ->update([
                //         'imtiyaz_phone' => null
                //     ]);

                $cart_imtiyaz = CartImtiyaz::query()
                ->where('cart_id', $cart_id)
                ->whereNull('deleted_at')->pluck('phone')->toArray();

                //2

                // dd($cart_imtiyaz);

                $cart_seats =  CartSeat::query()
                ->where('cart_id', $cart_id)
                ->whereNull('deleted_at')
                ->orderBy('price' , 'desc')
                ->get();


                foreach($cart_seats as $index => $cart_seat){

                    if($index % 2 == 1){
                        $cart_seat->imtiyaz_phone = $cart_imtiyaz[0] ?? null;
                        unset($cart_imtiyaz[0]);
                        $cart_imtiyaz = array_values($cart_imtiyaz);
                        // $cart_imtiyaz = $cart_imtiyaz->values();

                    }else{
                        $cart_seat->imtiyaz_phone = null; 
                    }
                    
                    $cart_seat->save();

                }



                DB::commit();

            } else {
               
                throw new Exception("No records found");
            }
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }

        return $cart_imtiyaz;
    }

    public function checkCouponInCart($cart_id, $coupon_id)
    {

        try {

            return CartCoupon::query()
                ->whereNull('deleted_at')
                ->where('coupon_id', $coupon_id)
                ->where('cart_id', $cart_id)
                ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e->getMessage());
        }
    }
    public function addCouponToCart($cart_id, $coupon)
    {



        $coupon_discounts = CartCoupon::where('cart_id', $cart_id)->whereNull('deleted_at')->sum('amount');
        $total_seats = CartSeat::where('cart_id', $cart_id)->whereNull('deleted_at')->sum('price');

        if ($total_seats - $coupon_discounts <= 0) {
            throw new Exception("The remaning amount is already 0");
        }


        try {
            $cart_coupon = new CartCoupon();
            $cart_coupon->coupon_id = $coupon->id;
            $cart_coupon->cart_id = $cart_id;
            $cart_coupon->amount = $coupon->discount_flat;
            $coupon->used_at = now();
            $cart_coupon->save();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return $cart_coupon;
    }

    public function removeCouponFromCart($cart_id, $coupon_code)
    {
        try {
            $cart_coupon = CartCoupon::select('cart_coupons.id')->where('cart_coupons.cart_id', $cart_id)
            ->join('coupons' , 'cart_coupons.coupon_id' , 'coupons.id')
            ->where('coupons.code' , $coupon_code)
            ->firstOrFail();
        
            CartCoupon::where('id' , $cart_coupon->id)->delete();
    
        } catch (ModelNotFoundException $e) {
            throw new Exception($e->getMessage());
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function getCartDetails($cart)
    {

        try {
            $cart_id = $cart->id;


            $cart_coupons = $this->getCartCoupons($cart_id);
            $coupon_ids = $cart_coupons->pluck('coupon_id');
            $coupon_codes = $this->couponRepository->getCouponsByIds($coupon_ids)->pluck('code');

            $imtiyaz_phones = $this->getCartImtiyaz($cart_id)->pluck('phone');


            $cart_seats = $this->getCartSeats($cart_id);
            $zone_ids = $cart_seats->pluck('zone_id');

            $zones = $this->zoneRepository->getZones($zone_ids)->keyBy('id');

            $total_discount = 0;

            $cart_seats = $cart_seats->map(function ($cart_seat) use ($zones, &$total_discount) {
                $zone = $zones[$cart_seat['zone_id']];
                if (!$zone) {
                    return null;
                }


                $unit_price = $cart_seat['imtiyaz_phone'] ? 0 : $cart_seat['price'];

                $total_discount += $cart_seat["total_discount"];

                if (!($cart_seat['quantity'] ?? null)) {
                    $cart_seat['quantity'] = 1;
                }
                // NOTE Hovig add the movie show id hereee
                return [
                    'id' => $cart_seat['id'],
                    'movie_show_id' => $cart_seat['movie_show_id'],
                    'seat' => $cart_seat['seat'],
                    'type' => "Seat",
                    'theater' =>$cart_seat->theater->label,
                    'label' => $zone->priceGroup->label . ' ' . ($zone->default == 1 ? '' : $zone->condensed_label),
                    'unit_price' => currency_format($unit_price),
                    'quantity' => $cart_seat['quantity'],
                    'price' => currency_format($unit_price * $cart_seat['quantity']),
                ];
            })->filter();


            $total_seats = $cart_seats->whereNull('imtiyaz_phone')->sum('price.value');
            $total = $total_seats;


            $cart_items = $this->getCartItems($cart_id);
            $item_ids = $cart_items->pluck('branch_item_id');
            $items = $this->itemRepository->getItemsById($item_ids)->keyBy('id');

            $cart_items = $cart_items->map(function ($cart_item) use ($items) {
                $item = $items[$cart_item['branch_item_id']];
                $unit_price = $item->price;


                if (!($cart_item['quantity'] ?? null)) {
                    $cart_item['quantity'] = 1;
                }

                return [
                    'id' => $cart_item['id'],
                    'type' => "Item",
                    'label' => $item->label,
                    'unit_price' => currency_format($unit_price),
                    'quantity' => $cart_item['quantity'],
                    'price' => currency_format($unit_price * $cart_item['quantity']),
                ];
            });

            $total += $cart_items->sum('price.value');


            $cart_topups = $this->getCartTopups($cart_id);
            $cart_topups = $cart_topups->map(function ($cart_topup) {
                $unit_price = $cart_topup->amount;

                if (!($cart_topup['quantity'] ?? null)) {
                    $cart_topup['quantity'] = 1;
                }

                return [
                    'id' => $cart_topup['id'],
                    'type' => "Topup",
                    'label' => "Top-up amount",
                    'unit_price' => currency_format($unit_price),
                    'quantity' => $cart_topup['quantity'],
                    'price' => currency_format($unit_price * $cart_topup['quantity']),
                ];
            });



            $total += $cart_topups->sum('price.value');

            // $cart_coupons = $this->getCartCoupons($cart_id);
            $cart_coupons = $cart_coupons->map(function ($cart_coupon) {
                $unit_price = $cart_coupon->amount;


                if (!($cart_coupon['quantity'] ?? null)) {
                    $cart_coupon['quantity'] = 1;
                }

                return [
                    'id' => $cart_coupon['id'],
                    'type' => "Coupon",
                    'label' => "Applied Coupon ",
                    'unit_price' => currency_format($unit_price, "-"),
                    'quantity' => 1,
                    'price' => currency_format($unit_price, "-"),
                ];
            });

            $discount = $cart_coupons->sum('price.value');
            $discount = $discount >= $total_seats ? $total_seats : $discount;

            $total -= $discount;



            $cart_imtiyaz=$this->getCartImtiyaz($cart_id);
            $cart_imtiyaz = $cart_imtiyaz->map(function ($cart_imtiyaz) {
              
              

                return [
                    'id' => $cart_imtiyaz['id'],
                    'type' => "Imtiyaz",
                    'label' => "Applied Imtiyaz ",
                 
                    'phone' => $cart_imtiyaz['phone'],
                ];
            });





            return [
                'cart_id' => $cart->id,
                'coupon_codes' => $coupon_codes->implode(", "),
                'coupons' => $coupon_codes->values(),
                'imtiyaz' => $imtiyaz_phones->values(),
                'user_id' => $cart->user_id,
                'card_number' => $cart->card_number,
                'subtotal' => currency_format($total),
                'discount' => currency_format($discount, "-"),
                'lines' => [...$cart_items, ...$cart_seats, ...$cart_topups, ...$cart_coupons],
            ];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getImtiyazCountFromCart($cart_id)
    {
        return CartImtiyaz::whereNull('deleted_at')->where('cart_id', $cart_id)->count();
    }

    public function getSeatsByCartId($cart_id)
    {
        try {
            return CartSeat::whereNull('deleted_at')
                ->where('cart_id', $cart_id)
                ->orderBy('price', 'DESC')
                ->get();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function getImtiyazByCartId($cart_id)
    {
        try {
            return  CartImtiyaz::whereNull('deleted_at')->where('cart_id', $cart_id)->get();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }



    public function getCouponCountFromCart($cart_id)
    {
        return CartCoupon::whereNull('deleted_at')->where('cart_id', $cart_id)->count();
    }


 
}
