<?php

namespace App\Repositories;


use App\Interfaces\CardRepositoryInterface;
use App\Interfaces\CartRepositoryInterface;
use App\Interfaces\CouponRepositoryInterface;
use App\Interfaces\OrderRepositoryInterface;
use App\Interfaces\PosUserRepositoryInterface;
use App\Interfaces\PriceGroupZoneRepositoryInterface;
use App\Interfaces\TheaterRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Models\BranchItem;
use App\Models\CartCoupon;

use App\Models\Item;
use App\Models\Movie;
use App\Models\MovieShow;

use App\Models\Order;
use App\Models\OrderCoupon;
use App\Models\OrderItem;
use App\Models\OrderSeat;
use App\Models\OrderTopup;
use App\Models\PaymentMethod;
use App\Models\ReservedSeat;
use App\Models\Theater;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class OrderRepository implements OrderRepositoryInterface
{


    private CartRepositoryInterface $cartRepository;
    private CardRepositoryInterface $cardRepository;
    private TheaterRepositoryInterface $theaterRepository;
    private UserRepositoryInterface $userRepository;
    private PriceGroupZoneRepositoryInterface $priceGroupZoneRepository;
    private PosUserRepositoryInterface $posUserRepository;
    private CouponRepositoryInterface $couponRepository;

    public function __construct(
        CartRepositoryInterface $cartRepository,
        TheaterRepositoryInterface $theaterRepository,
        CardRepositoryInterface $cardRepository,
        UserRepositoryInterface $userRepository,
        PosUserRepositoryInterface $posUserRepository,
        PriceGroupZoneRepositoryInterface $priceGroupZoneRepository,
        CouponRepositoryInterface $couponRepository
    ) {
        $this->cartRepository = $cartRepository;
        $this->theaterRepository = $theaterRepository;
        $this->cardRepository = $cardRepository;
        $this->userRepository = $userRepository;
        $this->posUserRepository = $posUserRepository;
        $this->priceGroupZoneRepository = $priceGroupZoneRepository;
        $this->couponRepository = $couponRepository;
    }


    public function createOrderFromCart($payment_attempt, $branch_id = null)
    {

        $cart_id = $payment_attempt->reference;
        $payment_method_id = $payment_attempt->payment_method_id;

        try {
            $cart = $this->cartRepository->getCartById($cart_id);
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
        $system_id = $cart->system_id;
        $user_id = $cart->user_id;

        if ($user_id == null) {

            try {
                $user_card = $this->cardRepository->getCardByBarcode($cart->card_number);
                $user_id =  $user_card->user_id ?? null;
            } catch (\Throwable $th) {
                $user_id = null;
            }
        }

        $cart_seats = $this->cartRepository->getCartSeats($cart_id);
        $cart_items = $this->cartRepository->getCartItems($cart_id);
        $cart_topups = $this->cartRepository->getCartTopups($cart_id);
        $cart_coupons = $this->cartRepository->getCartCoupons($cart_id);

        $order = new Order();
        $order->system_id = $system_id;
        $order->barcode =   $this->generateBarcode();
        $order->reference =  $this->generateReference();
        $order->user_id =  $user_id;
        // $order->long_id =  $this->generateLongId($order->id);
        $order->pos_user_id =  $cart->pos_user_id;
        $order->payment_method_id = $payment_method_id;
        $order->payment_reference = $payment_attempt->payment_reference;


        if (!$branch_id && ($cart_seats[0]['theater_id'] ?? null)) {
            $theater = Theater::find($cart_seats[0]['theater_id']);
            $branch_id = $theater->branch_id ?? null;
        }


        if (!$branch_id && isset($cart_items[0])) {
            $branchItem = BranchItem::find($cart_items[0]->branch_item_id);
            $branch_id = $branchItem->branch_id ?? null;
        }

        $order->branch_id = $branch_id;
        $order->save();


        $order->long_id = $this->generateLongId($order->id);


        $order->save();

        $total_points = 0;
        try {
            $cart_coupon_ids = $this->cartRepository->getCartCouponsIds($cart->id);
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
        try {
            $coupons = $this->couponRepository->getCouponsByIds($cart_coupon_ids);
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }


        foreach ($coupons as $coupon) {
            $coupon->order_id = $order->id;
            $coupon->used_at = now();
            $coupon->save();
        }



        foreach ($cart_seats as $cart_seat) {

            $price = $cart_seat['price'];

            $points_conversion = 1;
            $total_points += $price * $points_conversion;

            $movie = Movie::find($cart_seat['movie_id']);

            $dist_share_percentage = 0;
            if ($movie && $movie->commission_settings) {
                $settings = json_decode($movie->commission_settings, true);

                $week = $cart_seat['week'];
                $conditions = $settings['conditions'] ?? [];
                $defaultPercentage = $settings['defaultPercentage'] ?? 0;


                $index = $week - 1;

                if (isset($conditions[$index])) {
                    $dist_share_percentage = $conditions[$index];
                } else {
                    $dist_share_percentage = $defaultPercentage;
                }
            }

            $orderSeat = new OrderSeat();
            $orderSeat->seat = $cart_seat['seat'];
            $orderSeat->label =  $cart_seat->zone->label;
            $orderSeat->price = $cart_seat['price'];
            $orderSeat->gained_points = $price * $points_conversion;
            $orderSeat->order_id = $order->id;
            $orderSeat->movie_show_id = $cart_seat['movie_show_id'];
            $orderSeat->movie_id = $cart_seat['movie_id'];
            $orderSeat->screen_type_id = $cart_seat['screen_type_id'];
            $orderSeat->theater_id = $cart_seat['theater_id'];
            $orderSeat->date = $cart_seat['date'];
            $orderSeat->time_id = $cart_seat['time_id'];
            $orderSeat->week = $cart_seat['week'];
            $orderSeat->zone_id = $cart_seat['zone_id'];
            $orderSeat->dist_share_percentage = $dist_share_percentage;
            // $orderSeat->dist_share_amount = $price * ($dist_share_percentage / 100);
            $orderSeat->dist_share_amount = calculate_share_amount($price,$dist_share_percentage,5);


            $orderSeat->save();
            $reservedSeat = new ReservedSeat();
            // dd($cart_seat['movie_show_id']);
            $reservedSeat->movie_show_id = $cart_seat['movie_show_id'];
            $reservedSeat->seat = $cart_seat['seat'];
            $reservedSeat->save();
        }

        if ($user_id) {
            try {
                $user = $this->userRepository->getUserById($user_id);
                $this->cardRepository->createLoyaltyTransaction("in", $total_points, $user, "Add points from tickets", $order->id);
            } catch (\Throwable $th) {
                throw new Exception($th->getMessage());
            }
        }


        foreach ($cart_items as $cart_item) {

            $branch_item = BranchItem::find($cart_item['branch_item_id']);

            $orderItem = new OrderItem();
            $orderItem->branch_item_id = $cart_item['branch_item_id'];
            $orderItem->item_id = $branch_item->item_id;
            $orderItem->order_id = $order->id;
            $orderItem->price = $branch_item->price;
            $orderItem->label = $branch_item->item->label;
            $orderItem->item_code = $branch_item->item->item_code;
            $orderItem->save();
        }

        $total = 0;
        foreach ($cart_topups as $cart_topup) {

            $total += $cart_topup->amount;
            $orderTopup = new OrderTopup();
            $orderTopup->order_id = $order->id;
            $orderTopup->price = $cart_topup->amount;
            $orderTopup->label = $cart_topup->label;
            $orderTopup->save();
        }

        foreach ($cart_coupons as $cart_coupon) {

            $total += $cart_coupon->amount;
            $orderCoupon = new OrderCoupon();
            $orderCoupon->order_id = $order->id;
            $orderCoupon->amount = $cart_coupon->amount;
            $orderCoupon->coupon_id = $cart_coupon->coupon_id;
            $orderCoupon->save();
        }


        if ($total > 0 && $user_id) {

            if ($cart->pos_user_id) {
                $operator_type = "App\Models\PosUser";
                $operator_id = $cart->pos_user_id;
            } elseif ($cart->user_id) {
                $operator_type = "App\Models\User";
                $operator_id = $cart->user_id;
            } else {
                $operator_type = null;
                $operator_id = null;
            }

            $this->cardRepository->createWalletTransaction("in", $total, $user, "Recharge wallet", $order->id, null, $operator_id, $operator_type);
        }

        $this->cartRepository->expireCart($cart_id);

        return [
            'order_id' => $order->id,
            'cart_seats' => $cart_seats,
            'cart_items' => $cart_items,
            'cart_topups' => $cart_topups,
        ];
    }
    public function getUserOrders($user_id)
    {

        try {
            $user_order = Order::where('user_id', $user_id)
                ->whereNull('deleted_at')->get();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return $user_order;
    }
    public function getOrderByBarcode($barcode)
    {

        try {
            $card = Order::where('barcode', $barcode)
                ->whereNull('deleted_at')->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException("Order with Barcode {$barcode} not found .");
        }

        return $card;
    }
    public function getOrderById($order_id)
    {

        try {
            $order = Order::where('id', $order_id)->whereNull('deleted_at')->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e->getMessage());
        }

        return $order;
    }
    public function getOrderSeats($order_id, $grouped = false)
    {
        try {

            if ($grouped) {
                $select = [
                    DB::raw("CONCAT(COALESCE(zone_id,'0') ,'_', COALESCE(movie_show_id, '0')) as identifier"),
                    'order_id',
                    'seat',
                    'zone_id',
                    'movie_show_id',
                    'movie_id',
                    'screen_type_id',
                    'theater_id',
                    'date',
                    'time_id',
                    'week',
                    'created_at',
                    'price',
                    // 'final_price',
                    // 'discount',
                    DB::raw('count(*) as quantity'),
                    // DB::raw('sum(discount) as total_discount'),


                    DB::raw("GROUP_CONCAT(seat ORDER BY seat) AS seats")
                ];
            } else {
                $select = "*";
            }

            $user_order_seat = OrderSeat::select($select)->whereNull('deleted_at')
                ->where('order_id', $order_id)
                ->whereNull('refunded_at')
                ->when($grouped, function ($query) {
                    $query->groupBy('identifier');
                })
                ->get();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        // dd($user_cart_seat);
        return $user_order_seat;
    }


    public function getOrderRefundedSeats($order_id, $grouped = false)
    {
        try {

            if ($grouped) {
                $select = [
                    DB::raw("CONCAT(COALESCE(zone_id,'0') ,'_', COALESCE(movie_show_id, '0')) as identifier"),
                    'order_id',
                    'seat',
                    'zone_id',
                    'movie_show_id',
                    'movie_id',
                    'screen_type_id',
                    'theater_id',
                    'date',
                    'time_id',
                    'week',
                    'created_at',
                    'price',
                    // 'final_price',
                    // 'discount',
                    DB::raw('count(*) as quantity'),
                    // DB::raw('sum(discount) as total_discount'),


                    DB::raw("GROUP_CONCAT(seat ORDER BY seat) AS seats")
                ];
            } else {
                $select = "*";
            }

            $user_order_seat = OrderSeat::select($select)->whereNull('deleted_at')
                ->where('order_id', $order_id)
                ->whereNotNull('refunded_at')
                ->when($grouped, function ($query) {
                    $query->groupBy('identifier');
                })
                ->get();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        // dd($user_cart_seat);
        return $user_order_seat;
    }

    public function getOrderSeatsByIds($order_id, $order_seat_ids)
    {
        try {
            $order_seats = OrderSeat::where('order_id', $order_id)
                ->whereIn('id', $order_seat_ids)
                ->whereNull('refunded_at')
                ->get();


            if ($order_seats->isEmpty()) {
                throw new ModelNotFoundException("No matching order seats found for the given order and seat IDs.");
            }
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException("Order Seats with IDs " . implode(', ', $order_seat_ids) . " and order id {$order_id} not found.");
        }
        return $order_seats;
    }


    public function getOrderSeatsByCodes($order_id, $order_seat_codes)
    {
        try {
            $order_seats = OrderSeat::where('order_id', $order_id)
                ->whereIn('seat', $order_seat_codes)
                ->whereNull('refunded_at')
                ->get();


            if ($order_seats->isEmpty()) {
                throw new ModelNotFoundException("No matching order seats found for the given order and seat IDs.");
            }
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException("Order Seats with IDs " . implode(', ', $order_seat_codes) . " and order id {$order_id} not found.");
        }
        return $order_seats;
    }


    public function getOrderCoupons($order_id)
    {
        try {
            $order_coupons = OrderCoupon::whereNull('deleted_at')
                ->where('order_id', $order_id)

                ->get();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        return $order_coupons;
    }


    public function getOrderItems($order_id, $grouped = false)
    {


        if ($grouped) {
            $select = [DB::raw("CONCAT(COALESCE(item_id, '0'), '') as concatenated_item_id"), 'order_id', 'item_id', 'price', 'label', DB::raw('count(*) as quantity')];

            // $select = [ DB::raw("CONCAT(COALESCE(item_id,'0')  as item_id") , 'item_id'  , DB::raw('count(*) as quantity')];
        } else {
            $select = "*";
        }
        try {
            $user_order_item = OrderItem::select($select)->whereNull('deleted_at')
                ->where('order_id', $order_id)
                ->when($grouped, function ($query) {
                    $query->groupBy('item_id');
                })
                ->get();

            // dd($user_order_item);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        return $user_order_item;
    }
    public function getOrderTopups($order_id, $grouped = false)
    {
        if ($grouped) {
            $select = ['order_id', 'price', DB::raw('count(*) as quantity')];

            // $select = [ DB::raw("CONCAT(COALESCE(item_id,'0')  as item_id") , 'item_id'  , DB::raw('count(*) as quantity')];
        } else {
            $select = "*";
        }
        try {
            $user_order_topup = OrderTopup::select($select)->whereNull('deleted_at')
                ->where('order_id', $order_id)
                ->when($grouped, function ($query) {
                    $query->groupBy('price');
                })
                ->get();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return $user_order_topup;
    }
    public function getPaymentMethodById($payment_method_id)
    {
        try {
            return PaymentMethod::find($payment_method_id);
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e->getMessage());
        }
    }
    public function getPosuserLastOrder($pos_user_id)
    {
        try {
            return Order::whereNull('deleted_at')
                ->where('pos_user_id', $pos_user_id)
                ->orderBy('id', 'desc')
                ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e->getMessage());
        }
    }

    public function generateReference()
    {
        do {
            $reference = str(str()->random(14))->upper();
        } while (Order::where('reference', $reference)->whereNull('deleted_at')->exists());

        return $reference;
    }

    public function generateLongId($id)
    {
        return date("Y") . "-" . date("m") . '-' . str_pad($id, 6, '0', STR_PAD_LEFT);
    }


    public function generateBarcode()
    {
        do {
            $number = (string) rand(10000000000000000, 99999999999999999);
        } while (Order::where('barcode', $number)->whereNull('deleted_at')->first());

        return $number;
    }
}
