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
        try {
            $user_cart = Cart::where('id', $cart_id)
                ->where('expires_at', '>', now())->whereNull('deleted_at')->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException("Cart with ID {$cart_id} not found or expired.");
        }

        return $user_cart;
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
    public function addSeatToCart($cart_id, $seat, $movie_show, $zone_id)
    {


        try {

            $price = $this->priceGroupZoneRepository->getPriceByZonePerDate($zone_id, $movie_show->date);

            $cart_seat = new CartSeat();
            $cart_seat->seat = $seat;
            $cart_seat->cart_id = $cart_id;
            $cart_seat->zone_id = $zone_id;
            $cart_seat->movie_show_id = $movie_show->id;
            $cart_seat->price = $price;
            $cart_seat->final_price = $price;
            $cart_seat->discount = 0;
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
                ->where('movie_show_id', $movie_show_id)->firstOrFail();
            $cart_seat->delete();
        } catch (ModelNotFoundException $e) {
            throw new Exception($e->getMessage());
        } catch (Exception $e) {

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
    public function removeItemFromCart($cart_id, $item_id)
    {
        try {
            $cart_item = CartItem::where('cart_id', $cart_id)->where('item_id', $item_id)->firstOrFail();
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
            ->join('carts', 'cart_seats.cart_id', '=', 'carts.id')
            ->where('carts.expires_at', '>', now())
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
                ->orderBy('price' , 'DESC')
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

        $select = $grouped ? ['cart_id', 'amount', DB::raw('count(*) as quantity')] : "*";

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
    public function removeImtiyazFromCart($cart_id)
    {
        try {
            $cart_imtiyaz =  CartImtiyaz::query()
                ->where('cart_id', $cart_id)
                ->whereNull('deleted_at');

            if ($cart_imtiyaz->count() > 0) {
                $cart_imtiyaz->delete();

                CartSeat::query()
                ->where('cart_id', $cart_id)
                ->whereNull('deleted_at')
                ->update([
                    'imtiyaz_phone' => null
                ]);


            } else {
                throw new Exception("No records found");
            }
        } catch (Exception $e) {
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

    public function removeCouponFromCart($cart_id, $coupon_id)
    {
        try {
            $cart_coupon = CartCoupon::where('cart_id', $cart_id)->where('coupon_id', $coupon_id)->firstOrFail();
            $cart_coupon->delete();
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
            // $totalDiscounts = $validCoupons->sum('flat_discount');




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

                if(!($cart_seat['quantity'] ?? null)){
                    $cart_seat['quantity'] = 1;
                }

                return [
                    'id' => $cart_seat['id'],
                    'type' => "Seat",
                    'label' => $zone->priceGroup->label . ' ' . ($zone->default == 1 ? '' : $zone->condensed_label),
                    'unit_price' => currency_format($unit_price),
                    'quantity' => $cart_seat['quantity'],
                    'price' => currency_format($unit_price * $cart_seat['quantity']),
                ];
            })->filter();


            $total_seats = $cart_seats->whereNull('imtiyaz_phone')->sum('price.value');
            $total = $total_seats;


            $cart_items = $this->getCartItems($cart_id);
            $item_ids = $cart_items->pluck('item_id');
            $items = $this->itemRepository->getItemsById($item_ids)->keyBy('id');

            $cart_items = $cart_items->map(function ($cart_item) use ($items) {
                $item = $items[$cart_item['item_id']];
                $unit_price = $item->price;


                if(!($cart_item['quantity'] ?? null)){
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

                if(!($cart_topup['quantity'] ?? null)){
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

            $cart_coupons = $this->getCartCoupons($cart_id);
            $cart_coupons = $cart_coupons->map(function ($cart_coupon) {
                $unit_price = $cart_coupon->amount;


                if(!($cart_coupon['quantity'] ?? null)){
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

            return [
                'cart_id' => $cart->id,
                'coupon_codes' => $coupon_codes->implode(", "),
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

    public function getImtiyazByCartId($cart_id){
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
