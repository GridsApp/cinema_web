<?php

namespace App\Repositories;


use App\Interfaces\CartRepositoryInterface;
use App\Interfaces\ItemRepositoryInterface;
use App\Interfaces\ZoneRepositoryInterface;
use App\Models\Coupon;
use App\Models\System;
use App\Models\UserCard;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\CartSeat;
use App\Models\CartTopup;
use App\Models\OrderSeat;
use App\Models\ReservedSeat;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class CartRepository implements CartRepositoryInterface
{
    private ItemRepositoryInterface $itemRepository;
    private ZoneRepositoryInterface $zoneRepository;



    public function __construct(ItemRepositoryInterface $itemRepository, ZoneRepositoryInterface $zoneRepository)
    {
        $this->itemRepository = $itemRepository;
        $this->zoneRepository = $zoneRepository;
    }


    public function checkCart($cart_id, $user_id, $user_type)
    {
        try {

            $field = get_user_field_from_type($user_type);

            $user_cart = Cart::where('id', $cart_id)
                ->where($field, $user_id)
                ->where('expires_at', '>', now())->whereNull('deleted_at')->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException("Cart with ID {$cart_id} not found or expired.");
        }

        return $user_cart;
    }
    public function getCartById($cart_id)
    {
        try {
            $user_cart = Cart::where('id', $cart_id)
                ->where('expires_at', '>', now())->whereNull('deleted_at')->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException("Cart with ID {$cart_id} not found or expired.");
        }

        return $user_cart;
    }

    public function getSystemById($system_id)
    {

        try {

            return System::where('id', $system_id)->whereNull('deleted_at')->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e->getMessage());
        }
    }
    public function getCouponByCode($code)
    {

        try {
            $coupon = Coupon::where('code', $code)
                ->whereNull('deleted_at')->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException("Coupon with Code {$code} not found .");
        }

        return $coupon;
    }

    public function createCart($user_id, $user_type, $system_id)
    {
        try {

            $field = get_user_field_from_type($user_type);


            $cart = new Cart();
            $cart->{$field} = $user_id;
            $cart->system_id = $system_id;
            $cart->expires_at = now()->addMinutes(3600);
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

    public function addItemToCart($cart_id, $item_id)
    {
        try {
            $cart_item = new CartItem();
            $cart_item->item_id = $item_id;
            $cart_item->cart_id = $cart_id;
            $cart_item->save();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return $cart_item;
    }

    public function addTopupToCart($cart_id, $amount)
    {


        try {
            $cart_topup = new CartTopup();
            $cart_topup->amount = $amount;
            $cart_topup->cart_id = $cart_id;
            $cart_topup->save();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return $cart_topup;
    }
    public function addCouponToCart($cart_id, $coupon_id)
    {
        try {
            $cart = $this->getCartById($cart_id);
            $cart->coupon_id = $coupon_id;
            $cart->save();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        return $cart;
    }

    public function addCardNumberTocart($cart_id, $card_number)
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


    public function removeCouponFromCart($cart_id)
    {
        try {
            $cart = $this->getCartById($cart_id);

            $cart->coupon_id = null;
            $cart->save();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    public function removeCardNumberFromCart($cart_id)
    {
        try {
            $cart = $this->getCartById($cart_id);

            $cart->card_number = null;
            $cart->save();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }


    public function removeItemFromCart($cart_id, $item_id)
    {
        try {
            CartItem::where('cart_id', $cart_id)->where('item_id', $item_id)->delete();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    public function removeTopupFromCart($cart_id)
    {
        try {
            CartTopup::where('cart_id', $cart_id)->delete();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }


    public function addSeatToCart($cart_id, $seat, $movie_show_id, $zone_id)
    {
        try {

            $cart_seat = new CartSeat();
            $cart_seat->seat = $seat;
            $cart_seat->cart_id = $cart_id;
            $cart_seat->zone_id = $zone_id;
            $cart_seat->movie_show_id = $movie_show_id;
            $cart_seat->save();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        return $cart_seat;
    }

    public function removeSeatFromCart($cart_id, $seat, $movie_show_id)
    {

        try {
            $cart_seat = CartSeat::where('cart_id', $cart_id)
                ->where('seat', $seat)
                ->where('movie_show_id', $movie_show_id)
                ->delete();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }


    public function getCartSeats($cart_id, $grouped = false)
    {
        try {

            if ($grouped) {
                $select = [DB::raw("CONCAT(COALESCE(zone_id,'0') ,'_', COALESCE(movie_show_id, '0')) as identifier"), 'cart_id', 'zone_id', 'movie_show_id', DB::raw('count(*) as quantity')];
            } else {
                $select = "*";
            }

            $user_cart_seat = CartSeat::select($select)->whereNull('deleted_at')
                ->where('cart_id', $cart_id)
                ->when($grouped, function ($query) {
                    $query->groupBy('identifier');
                })
                ->get();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        // dd($user_cart_seat);
        return $user_cart_seat;
    }

    public function getReservedSeats($movie_show_id)
    {
        $cart_seats = CartSeat::whereNull('cart_seats.deleted_at')
            ->where('cart_seats.movie_show_id', $movie_show_id)
            ->join('carts', 'cart_seats.cart_id', '=', 'carts.id')
            ->where('carts.expires_at', '>', now())
            ->pluck('seat');


        $reserved_seats = ReservedSeat::whereNull('deleted_at')
            ->where('movie_show_id', $movie_show_id)->pluck('seat');

        $booked = collect([]);
        $booked = $booked->merge($cart_seats)->merge($reserved_seats)->unique()->values()->toArray();
        return $booked;
    }




    public function getCartItems($cart_id, $grouped = false)
    {
        if ($grouped) {
            $select = [DB::raw("CONCAT(COALESCE(item_id, '0'), '') as concatenated_item_id"), 'cart_id', 'item_id', DB::raw('count(*) as quantity')];

            // $select = [ DB::raw("CONCAT(COALESCE(item_id,'0')  as item_id") , 'item_id'  , DB::raw('count(*) as quantity')];
        } else {
            $select = "*";
        }
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
        if ($grouped) {
            $select = ['cart_id', 'amount', DB::raw('count(*) as quantity')];

            // $select = [ DB::raw("CONCAT(COALESCE(item_id,'0')  as item_id") , 'item_id'  , DB::raw('count(*) as quantity')];
        } else {
            $select = "*";
        }
        try {
            $user_cart_topup = CartTopup::select($select)->whereNull('deleted_at')
                ->where('cart_id', $cart_id)
                ->when($grouped, function ($query) {
                    $query->groupBy('amount');
                })
                ->get();

            // dd($user_cart_topup);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return $user_cart_topup;
    }

    public function getCartDetails($cart)
    {
        try {

            $cart_id = $cart->id;



            // $cart = $this->getCartById($cart_id);
    
            $coupon_code = $cart->coupon ? $cart->coupon->code : null;
 
            $cart_seats = $this->getCartSeats($cart_id, true);
            $zone_ids = $cart_seats->pluck('zone_id');
            $zones = $this->zoneRepository->getZonesPrices($zone_ids)->keyBy('id');

            $cart_seats = $cart_seats->map(function ($cart_seat) use ($zones) {
                $zone = $zones[$cart_seat['zone_id']];
                if (!$zone) {
                    return null;
                }

                $unit_price = $zone->price;

                return [
                    'id' => $cart_seat['cart_id'],
                    'type' => "Seat",
                    'label' => $zone->label,
                    'unit_price' => currency_format($unit_price),
                    'quantity' => $cart_seat['quantity'],
                    'price' => currency_format($unit_price * $cart_seat['quantity']),
                ];
            })->filter();

            $total = $cart_seats->sum('price.value');


            $cart_items = $this->getCartItems($cart_id, true);
            $item_ids = $cart_items->pluck('item_id');
            $items = $this->itemRepository->getItemsById($item_ids)->keyBy('id');

            $cart_items = $cart_items->map(function ($cart_item) use ($items) {
                $item = $items[$cart_item['item_id']];
                $unit_price = $item->price;

                return [
                    'id' => $cart_item['cart_id'],
                    'type' => "Item",
                    'label' => $item->label,
                    'unit_price' => currency_format($unit_price),
                    'quantity' => $cart_item['quantity'],
                    'price' => currency_format($unit_price * $cart_item['quantity']),
                ];
            });

            $total += $cart_items->sum('price.value');


            $cart_topups = $this->getCartTopups($cart_id, true);
            $cart_topups = $cart_topups->map(function ($cart_topup) {
                $unit_price = $cart_topup->amount;

                return [
                    'id' => $cart_topup['cart_id'],
                    'type' => "Topup",
                    'label' => "Top-up amount",
                    'unit_price' => currency_format($unit_price),
                    'quantity' => $cart_topup['quantity'],
                    'price' => currency_format($unit_price * $cart_topup['quantity']),
                ];
            });

            $total += $cart_topups->sum('price.value');


            return [
                'coupon_code' => $coupon_code,
                'subtotal' => currency_format($total),
                'discount'=> currency_format(0),
                'lines' => [...$cart_items, ...$cart_seats, ...$cart_topups],
            ];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
