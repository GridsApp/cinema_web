<?php

namespace App\Repositories;

use App\Entities\UserOrdersEntity;
use App\Interfaces\CardRepositoryInterface;
use App\Interfaces\CartRepositoryInterface;
use App\Interfaces\OrderRepositoryInterface;
use App\Interfaces\PosUserRepositoryInterface;
use App\Interfaces\TheaterRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Models\CartItem;
use App\Models\Item;
use App\Models\MovieShow;
use App\Models\PriceGroupZone;
use App\Models\Theater;
use App\Models\UserCard;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderSeat;
use App\Models\OrderTopup;
use App\Models\ReservedSeat;
use ErrorException;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class OrderRepository implements OrderRepositoryInterface
{


    private CartRepositoryInterface $cartRepository;
    private CardRepositoryInterface $cardRepository;
    private TheaterRepositoryInterface $theaterRepository;
    private UserRepositoryInterface $userRepository;
    private PosUserRepositoryInterface $posUserRepository;

    public function __construct(
        CartRepositoryInterface $cartRepository,
        TheaterRepositoryInterface $theaterRepository,
        CardRepositoryInterface $cardRepository,
        UserRepositoryInterface $userRepository,
        PosUserRepositoryInterface $posUserRepository
    ) {
        $this->cartRepository = $cartRepository;
        $this->theaterRepository = $theaterRepository;
        $this->cardRepository = $cardRepository;
        $this->userRepository = $userRepository;
        $this->posUserRepository = $posUserRepository;
    }


    public function createOrderFromCart($payment_attempt)
    {


        $cart_id = $payment_attempt->reference;
        $payment_method_id = $payment_attempt->payment_method_id;

        // GET CART

        $cart = $this->cartRepository->getCartById($cart_id);

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

        $order = new Order();
        $order->system_id = $system_id;
        $order->barcode =   $this->generateBarcode();
        $order->reference =  $this->generateReference();
        $order->user_id =  $user_id;
        $order->pos_user_id =  $cart->pos_user_id;

        $order->payment_method_id = $payment_method_id;
        $order->save();

        $total_points = 0;

        foreach ($cart_seats as $cart_seat) {

            try {
                $movie_show = MovieShow::findOrFail($cart_seat['movie_show_id']);
            } catch (ModelNotFoundException $e) {
                throw new ModelNotFoundException("Movie with ID {$cart_seat['movie_show_id']} not found.");
            }


            // Check if movie theater exists
            // $theater_map = //getMovieShowTheaterMap()

            // if doesn't exists create it for the next customer

            // if(!$theater_map){
            //     // $theater_map = $this->theaterRepository->getTheaterMap($movie_show->theater_id);
            //     // Create it
            // }


            $theater_map = $this->theaterRepository->getTheaterMap($movie_show->theater_id);


            $object_seat = $this->theaterRepository->getSeatFromTheaterMap($theater_map, $cart_seat['seat']);

            $price_group_zone = PriceGroupZone::where('id', $object_seat['zone'])->first();
            $price = $price_group_zone ? $price_group_zone->price : 0;

            $points_conversion = 1;
            $total_points += $price * $points_conversion;

            $orderSeat = new OrderSeat();
            $orderSeat->seat = $cart_seat['seat'];
            $orderSeat->label =  $price_group_zone->label;
            $orderSeat->price = $price;
            $orderSeat->gained_points = $price * $points_conversion;
            $orderSeat->order_id = $order->id;

            $orderSeat->movie_show_id = $cart_seat['movie_show_id'];
            $orderSeat->zone_id = $cart_seat['zone_id'];
            $orderSeat->discount = 0;
            $orderSeat->final_price = $orderSeat->price - $orderSeat->discount;
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
            $item = Item::find($cart_item['item_id']);
            $orderItem = new OrderItem();
            $orderItem->item_id = $cart_item['item_id'];
            $orderItem->order_id = $order->id;
            $orderItem->price = $item->price;
            $orderItem->label = $item->label;
            $orderItem->save();
        }

        foreach ($cart_topups as $cart_topup) {

            $orderTopup = new OrderTopup();
            $orderTopup->order_id = $order->id;
            $orderTopup->price = $cart_topup->amount;
            $orderTopup->label = $cart_topup->label;
            $orderTopup->save();
        }

        $this->cartRepository->expireCart($cart_id);


        return [
            'order_id' => $order->id,
            'cart_seats' => $cart_seats,
            'cart_items' => $cart_items,
            'cart_topups' => $cart_topups,
        ];
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
                    'price',
                    'final_price',
                    'discount',
                    DB::raw('count(*) as quantity'),
                    DB::raw('sum(discount) as total_discount'),


                    DB::raw("GROUP_CONCAT(seat ORDER BY seat) AS seats")
                ];
            } else {
                $select = "*";
            }

            $user_order_seat = OrderSeat::select($select)->whereNull('deleted_at')
                ->where('order_id', $order_id)
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


    public function getOrderItems($order_id, $grouped = false)
    {
        if ($grouped) {
            $select = [DB::raw("CONCAT(COALESCE(item_id, '0'), '') as concatenated_item_id"), 'order_id', 'item_id', DB::raw('count(*) as quantity')];

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

    public function createOrderItemsFromCart() {}
    public function createOrderSeatsFromCart() {}



    public function generateReference()
    {
        do {
            $reference = str(str()->random(14))->upper();
        } while (Order::where('reference', $reference)->whereNull('deleted_at')->exists());

        return $reference;
    }
    public function generateBarcode()
    {
        do {
            $number = (string) rand(10000000000000000, 99999999999999999);
        } while (Order::where('barcode', $number)->whereNull('deleted_at')->first());

        return $number;
    }
}
