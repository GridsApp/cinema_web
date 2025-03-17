<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Interfaces\CardRepositoryInterface;
use App\Interfaces\CartRepositoryInterface;
use App\Interfaces\CouponRepositoryInterface;
use App\Interfaces\ItemRepositoryInterface;

use App\Interfaces\MovieShowRepositoryInterface;
use App\Interfaces\PriceGroupZoneRepositoryInterface;
use App\Interfaces\TheaterRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\ZoneRepositoryInterface;
use App\Models\CartImtiyaz;
use App\Models\CartSeat;
use App\Models\Coupon;
use App\Repositories\PriceGroupZoneRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use twa\cmsv2\Traits\APITrait;


class CartController extends Controller
{


    use APITrait;

    private CartRepositoryInterface $cartRepository;
    private MovieShowRepositoryInterface $movieShowRepository;
    private TheaterRepositoryInterface $theaterRepository;
    private ItemRepositoryInterface $itemRepository;
    private ZoneRepositoryInterface $zoneRepository;
    private CardRepositoryInterface $cardRepository;
    private UserRepositoryInterface $userRepository;
    private CouponRepositoryInterface $couponRepository;
    private PriceGroupZoneRepositoryInterface $priceGroupZoneRepository;

    public function __construct(
        CartRepositoryInterface $cartRepository,
        MovieShowRepositoryInterface $movieShowRepository,
        TheaterRepositoryInterface $theaterRepository,
        ItemRepositoryInterface $itemRepository,
        ZoneRepositoryInterface $zoneRepository,
        CardRepositoryInterface $cardRepository,
        UserRepositoryInterface $userRepository,
        CouponRepositoryInterface $couponRepository,
        PriceGroupZoneRepositoryInterface $priceGroupZoneRepository
    ) {
        $this->cartRepository = $cartRepository;
        $this->movieShowRepository = $movieShowRepository;
        $this->theaterRepository = $theaterRepository;
        $this->itemRepository = $itemRepository;
        $this->zoneRepository = $zoneRepository;
        $this->cardRepository = $cardRepository;
        $this->userRepository = $userRepository;
        $this->couponRepository = $couponRepository;
        $this->priceGroupZoneRepository = $priceGroupZoneRepository;
    }


    public function createCart()
    {

        $user = request()->user;
        $user_type = request()->user_type;

        $form_data = clean_request([]);

        try {
            $system_id = get_system_from_type($user_type);
        } catch (\Throwable $th) {
            return  $this->response(notification()->error("Error", $th->getMessage()));
        }
       

        try {
            $cart = $this->cartRepository->createCart($user->id, $user_type, $system_id);
        } catch (\Exception $th) {
            return  $this->response(notification()->error("Error", $th->getMessage()));
        }

        // return $this->responseData([
        //     'cart_id' => $cart->id,
        //     'timezone' => config('app.timezone'),
        //     'expires_at' => $cart->expires_at
        // ]);
        return $this->responseData([
            'cart_id' => $cart->id,
            'timezone' => config('app.timezone'),
            'expires_at' => $cart->expires_at
        ], notification()->success('Cart created', 'Cart created'));
    }
    public function expireCart()
    {

        $form_data = clean_request([]);
        $check = $this->validateRequiredFields($form_data, ['cart_id']);
        if ($check) {
            return $this->response($check);
        }

        $user = request()->user;
        $user_type = request()->user_type;

        try {
            $this->cartRepository->checkCart($form_data['cart_id'], $user->id, $user_type);
        } catch (\Exception $th) {
            return $this->response(notification()->error('Cart is Expired', $th->getMessage()));
        }

        try {
            $this->cartRepository->expireCart($form_data['cart_id']);
            return $this->response(notification()->success('Cart Expired successfully', 'Cart Expired successfully'));
        } catch (\Exception $th) {
            return  $this->response(notification()->error("Error", $th->getMessage()));
        }
    }
    public function addSeatsToCart()
    {
        $form_data = clean_request([]);
        $check = $this->validateRequiredFields($form_data, ['cart_id', 'seats', 'movie_show_id']);

        if ($check) {
            return $this->response($check);
        }

        $user = request()->user;
        $user_type = request()->user_type;

        try {
            $this->cartRepository->checkCart($form_data['cart_id'], $user->id, $user_type);
        } catch (\Exception $th) {
            return $this->response(notification()->error('Cart is Expired', $th->getMessage()));
        }

        try {
            $movie_show = $this->movieShowRepository->getMovieShowById($form_data['movie_show_id']);
        } catch (\Exception $th) {
            return $this->response(notification()->error('Movie Show Not found', $th->getMessage()));
        }

        try {
            $theater_map = $this->theaterRepository->getTheaterMap($movie_show->theater_id);
        } catch (\Exception $th) {
            return $this->response(notification()->error('Theater Not found', $th->getMessage()));
        }

        if (!is_array($form_data['seats']) || empty($form_data['seats'])) {
            return $this->response(notification()->error('Invalid seat data', 'Seats must be an array and not empty'));
        }


        try {
            $seats = $this->theaterRepository->getSeatsFromTheaterMap($theater_map, $form_data['seats']);
        } catch (\Exception $th) {
            return $this->response(notification()->error('Error getting seats', $th->getMessage()));
        }

        $reserved_seats = $this->cartRepository->getReservedSeats($form_data['movie_show_id']);

        if ($seats->pluck('code')->intersect($reserved_seats)->count() > 0) {
            return $this->response(notification()->error('Seats Alredy Reserved', 'Seats Alredy Reserved'));
        }



        try {
            DB::beginTransaction();

            foreach ($seats as $seat) {
                $this->cartRepository->addSeatToCart($form_data['cart_id'], $seat['code'], $movie_show, $seat['zone']);
            }

         

            DB::commit();
        } catch (\Exception $th) {
            // dd("here");
            DB::rollBack();
            return $this->response(notification()->error('Error adding seats to cart', $th->getMessage()));
        }

        return $this->response(notification()->success('Seats added to the cart successfully', 'Seats added successfully'));
    }
    public function removeSeatFromCart()
    {
        $form_data = clean_request([]);
        $check = $this->validateRequiredFields($form_data, ['cart_id', 'seat', 'movie_show_id']);

        if ($check) {
            return $this->response($check);
        }
        $user = request()->user;
        $user_type = request()->user_type;

        try {
            $this->cartRepository->checkCart($form_data['cart_id'], $user->id, $user_type);
        } catch (\Exception $th) {
            return $this->response(notification()->error('Cart is Expired', $th->getMessage()));
        }
        try {
            $this->cartRepository->removeSeatFromCart($form_data['cart_id'], $form_data['seat'], $form_data['movie_show_id']);
            return $this->response(notification()->success('Seat removed successfully', 'Seat removed successfully'));
        } catch (\Exception $e) {
            return $this->response(notification()->error('Error removing seat', $e->getMessage()));
        }
    }
    public function addItemToCart()
    {
        $form_data = clean_request([]);

        $check = $this->validateRequiredFields($form_data, ['cart_id', 'item_id']);
        if ($check) {
            return $this->response($check);
        }

        $user = request()->user;
        $user_type = request()->user_type;

        try {
            $this->cartRepository->checkCart($form_data['cart_id'], $user->id, $user_type);
        } catch (\Exception $th) {
            return $this->response(notification()->error('Cart is Expired', $th->getMessage()));
        }

        try {
            $this->itemRepository->getItemById($form_data['item_id']);
        } catch (\Exception $th) {
            return $this->response(notification()->error('Item not found', $th->getMessage()));
        }

        try {
            $this->cartRepository->addItemToCart($form_data['cart_id'], $form_data['item_id']);
            return $this->response(notification()->success('Item added  to the cart successfully', 'Item added successfully'));
        } catch (\Exception $e) {
            return $this->response(notification()->error('Error adding item to cart', $e->getMessage()));
        }
    }
    public function removeItemFromCart()
    {

        $form_data = clean_request([]);
        $check = $this->validateRequiredFields($form_data, ['cart_id', 'item_id']);

        if ($check) {
            return $this->response($check);
        }
        try {
            $this->itemRepository->getItemById($form_data['item_id']);
        } catch (\Exception $th) {
            return $this->response(notification()->error('Item not found', $th->getMessage()));
        }
        try {
            $this->cartRepository->removeItemFromCart($form_data['cart_id'], $form_data['item_id']);
            return $this->response(notification()->success('Item removed successfully', 'Item removed successfully'));
        } catch (\Exception $e) {
            return $this->response(notification()->error('Error removing Item', $e->getMessage()));
        }
    }
    public function addTopupToCart()
    {
        $form_data = clean_request([]);
        $check = $this->validateRequiredFields($form_data, ['cart_id', 'amount']);

        if ($check) {
            return $this->response($check);
        }
        //GET FROM SETTINGS
        $minimum_recharge_amount = get_setting("minimum_topup_amount");
        $maximum_recharge_amount =  get_setting("maximum_topup_amount");

        // dd($maximum_recharge_amount);

        if ($form_data['amount'] < $minimum_recharge_amount) {
            return $this->response(notification()->error('Invalid Amount', "Please enter amount greater than " . $minimum_recharge_amount));
        }
        if ($form_data['amount'] > $maximum_recharge_amount) {
            return $this->response(notification()->error('Invalid Amount', "Please enter amount less than " . $maximum_recharge_amount));
        }

        $user = request()->user;
        $user_type = request()->user_type;

        try {
            $cart = $this->cartRepository->checkCart($form_data['cart_id'], $user->id, $user_type);
        } catch (\Exception $th) {
            return $this->response(notification()->error('Cart is Expired', $th->getMessage()));
        }
        if (!$cart->card_number) {
            return $this->response(notification()->error("You don't have a card number", "This cart does not have a card number"));
        }

        try {
            $this->cartRepository->addTopupToCart($form_data['cart_id'], $form_data['amount']);
        } catch (\Exception $th) {
            return $this->response(notification()->error('Error adding amount to cart', $th->getMessage()));
        }

        return $this->response(notification()->success('Amount added to the cart successfully', 'Amount added successfully'));
    }
    public function removeTopupFromCart()
    {
        $form_data = clean_request([]);
        $check = $this->validateRequiredFields($form_data, ['cart_id']);

        if ($check) {
            return $this->response($check);
        }

        $user = request()->user;
        $user_type = request()->user_type;

        try {
            $cart = $this->cartRepository->checkCart($form_data['cart_id'], $user->id, $user_type);
        } catch (\Exception $th) {
            return $this->response(notification()->error('Cart is Expired', $th->getMessage()));
        }

        if (!$cart->card_number) {
            return $this->response(notification()->error("You don't have a card number", "This cart does not have a card number"));
        }

        try {
            $this->cartRepository->removeTopupFromCart($form_data['cart_id']);
            return $this->response(notification()->success('Top Up removed successfully', 'Top Up removed successfully'));
        } catch (\Exception $e) {
            return $this->response(notification()->error('Error removing Top Up', $e->getMessage()));
        }
    }
    public function removeImtiyazFromCart()
    {
        $form_data = clean_request([]);
        $check = $this->validateRequiredFields($form_data, ['cart_id']);

        if ($check) {
            return $this->response($check);
        }

        $user = request()->user;
        $user_type = request()->user_type;

        try {
            $cart = $this->cartRepository->checkCart($form_data['cart_id'], $user->id, $user_type);
        } catch (\Exception $th) {
            return $this->response(notification()->error('Cart is Expired', $th->getMessage()));
        }



        try {
            $this->cartRepository->removeImtiyazFromCart($form_data['cart_id']);
            return $this->response(notification()->success('Imtiyaz removed successfully', 'Imtiyaz removed successfully'));
        } catch (\Exception $e) {
            return $this->response(notification()->error('Error removing Imtiyaz', $e->getMessage()));
        }
    }

    public function addImtiyazToCart()
    {
        $form_data = clean_request([]);
        $check = $this->validateRequiredFields($form_data, ['cart_id', 'phones']);

        if ($check) {
            return $this->response($check);
        }

        if (!is_array($form_data['phones']) || empty($form_data['phones'])) {
            return $this->response(notification()->error('Invalid Phones data', 'Phones must be an array and not empty'));
        }

        $user = request()->user;
        $user_type = request()->user_type;

        try {
            $cart = $this->cartRepository->checkCart($form_data['cart_id'], $user->id, $user_type);
        } catch (\Exception $th) {
            return $this->response(notification()->error('Cart is Expired', $th->getMessage()));
        }


        $cart_coupon_count = $this->cartRepository->getCouponCountFromCart($form_data['cart_id']);

        if ($cart_coupon_count > 0) {
            return $this->response(notification()->error('Imtiyaz can not be added with coupon', "Imtiyaz can not be added with coupon"));
        }


        // $cart_imtiyaz = CartImtiyaz::whereNull('deleted_at')->where('cart_id', $form_data['cart_id'])->get();

        try {
            $cart_imtiyaz =  $this->cartRepository->getImtiyazByCartId($form_data['cart_id']);
            $count_imtiyaz = count($cart_imtiyaz);
        } catch (\Throwable $th) {
            return $this->response(notification()->error('Imtiyaz not found ', $th->getMessage()));
        }


        if ($count_imtiyaz > 0) {
            return $this->response(notification()->error('Imityaz already added', 'Imityaz already added'));
        }

        try {
            $cart_seats = $this->cartRepository->getCartSeats($form_data['cart_id']);
            $count_seats = count($cart_seats);
        } catch (\Throwable $th) {
            return $this->response(notification()->error('Seats not found ', $th->getMessage()));
        }

        //  CartSeat::whereNull('deleted_at')->where('cart_id', $form_data['cart_id'])->orderBy('price', 'DESC')->get();



        $eligibility = $count_seats % 2 == 0 ? $count_seats / 2 : ($count_seats - 1) / 2;


        if (count($form_data['phones']) > $eligibility) {
            return $this->response(notification()->error('Not eligible', 'Not eligible'));
        }


        try {
            DB::beginTransaction();

            $i = 1;

            foreach ($form_data['phones'] as $phone) {
                $this->cartRepository->addImtiyazToCart($form_data['cart_id'], $phone);

                $cart_seat = $cart_seats[$i] ?? null;

                if ($cart_seat) {
                    $cart_seat->imtiyaz_phone = $phone;
                    $cart_seat->save();
                }

                $i = $i + 2;
            }
            DB::commit();
        } catch (\Exception $th) {
            DB::rollBack();
            return $this->response(notification()->error('Error adding imtiyaz to cart', $th->getMessage()));
        }
        return $this->response(notification()->success('Imtiyaz Phone added to the cart successfully', 'Imtiyaz Phone added to the cart successfully'));
    }
    public function addCouponToCart()
    {
        $form_data = clean_request([]);
        $check = $this->validateRequiredFields($form_data, ['cart_id', 'code']);

        if ($check) {
            return $this->response($check);
        }

        $user = request()->user;
        $user_type = request()->user_type;

        try {
            $coupon = $this->couponRepository->getCouponByCode($form_data['code']);
        } catch (\Throwable $th) {
            return $this->response(notification()->error('Coupon not found or expired', $th->getMessage()));
        }


        try {
            $cart = $this->cartRepository->checkCart($form_data['cart_id'], $user->id, $user_type);
        } catch (\Exception $th) {
            return $this->response(notification()->error('Cart is Expired', $th->getMessage()));
        }


        $cart_imtiyaz_count = $this->cartRepository->getImtiyazCountFromCart($form_data['cart_id']);

        if ($cart_imtiyaz_count > 0) {
            return $this->response(notification()->error('Coupon can not be added with imtiyaz', "Coupon can not be added with imtiyaz"));
        }


        try {
            $this->cartRepository->checkCouponInCart($form_data['cart_id'], $coupon->id);
            return $this->response(notification()->error('Coupon was already added to cart', "Coupon was already added to cart"));
        } catch (\Exception $th) {
        }




        // Check if total of seats is > 0


        try {
            $this->cartRepository->addCouponToCart($form_data['cart_id'], $coupon);
        } catch (\Exception $th) {
            return $this->response(notification()->error('Error adding coupon to cart', $th->getMessage()));
        }


        return $this->response(notification()->success('Coupon added to the cart successfully', 'Coupon added successfully'));
    }
    public function removeCouponFromCart()
    {

        $form_data = clean_request([]);
        $check = $this->validateRequiredFields($form_data, ['cart_id', 'coupon_id']);

        if ($check) {
            return $this->response($check);
        }

        $user = request()->user;
        $user_type = request()->user_type;

        try {
            $this->cartRepository->checkCart($form_data['cart_id'], $user->id, $user_type);
        } catch (\Exception $th) {
            return $this->response(notification()->error('Cart is Expired', $th->getMessage()));
        }

        try {
            $this->cartRepository->removeCouponFromCart($form_data["cart_id"], $form_data["coupon_id"]);
            return $this->response(notification()->success('Coupon removed successfully', 'Coupon removed successfully'));
        } catch (\Exception $e) {
            return $this->response(notification()->error('Error removing Coupon', $e->getMessage()));
        }
    }

    public function addCardNumberToCart()
    {
        $form_data = clean_request([]);
        $check = $this->validateRequiredFields($form_data, ['cart_id', 'card_number']);

        if ($check) {
            return $this->response($check);
        }

        $user = request()->user;
        $user_type = request()->user_type;

        try {
            $this->cartRepository->checkCart($form_data['cart_id'], $user->id, $user_type);
        } catch (\Exception $th) {
            return $this->response(notification()->error('Cart is Expired', $th->getMessage()));
        }

        try {
            $this->cardRepository->getCardByBarcode($form_data['card_number']);
        } catch (\Exception $e) {
            return $this->response(notification()->error('Card number not  found', $e->getMessage()));
        }

        try {
            $this->cartRepository->addCardNumberToCart($form_data['cart_id'], $form_data['card_number']);
        } catch (\Exception $th) {
            return $this->response(notification()->error('Error adding Card Number to cart', $th->getMessage()));
        }

        return $this->response(notification()->success('Card Number added to the cart successfully', 'Card Number added successfully'));
    }

    public function removeCardNumberFromCart()
    {
        $form_data = clean_request([]);
        $check = $this->validateRequiredFields($form_data, ['cart_id']);

        if ($check) {
            return $this->response($check);
        }


        $user = request()->user;
        $user_type = request()->user_type;

        try {
            $this->cartRepository->checkCart($form_data['cart_id'], $user->id, $user_type);
        } catch (\Exception $th) {
            return $this->response(notification()->error('Cart is Expired', $th->getMessage()));
        }

        try {
            $this->cartRepository->removeCardNumberFromCart($form_data['cart_id']);
        } catch (\Exception $e) {
            return $this->response(notification()->error('Error Removing Card Number', $e->getMessage()));
        }

        return $this->response(notification()->success('Card Number removed successfully', 'Card Number removed successfully'));
    }

    public function details()
    {
        $body = clean_request();
        $check = $this->validateRequiredFields($body, ['cart_id']);

        if ($check) {
            return $this->response($check);
        }

        $user = request()->user;
        $user_type = request()->user_type;

        try {
            $cart = $this->cartRepository->checkCart($body['cart_id'], $user->id, $user_type);
        } catch (\Exception $e) {
            return $this->response(notification()->error('Error', $e->getMessage()));
        }
        $cartDetails = $this->cartRepository->getCartDetails($cart);

        if ($cartDetails['user_id']) {

            // get card info by user id

            try {
                $user = $this->userRepository->getUserById($cartDetails['user_id']);
            } catch (\Throwable $th) {
                throw new Exception($th->getMessage());
            }

            $card = $this->cardRepository->getActiveCard($user);

            // dd("here");
            $card_info = [
                'fullname' => $user->name,
                'phone' => $user->phone,
                'email' => $user->email,
                'card_number' => $card['barcode'],
                'loyalty_balance' => $card['loyalty_points_balance'],
                'wallet_balance' => $card['wallet_balance'],
                'type' => $card['type']
            ];
        } elseif ($cartDetails['card_number']) {

            try {
                $card = $this->cardRepository->getCardByBarcode($cartDetails['card_number']);
            } catch (\Exception $e) {
                return $this->response(notification()->error('Card Not Found', 'The card number provided is invalid or does not exist.'));
            }

            // $card = $this->cardRepository->getCardByBarcode($cartDetails['card_number']);

            try {
                $user = $this->userRepository->getUserById($card->user_id);
            } catch (\Exception $e) {
                return $this->response(notification()->error('User Not Found', 'User Not Found.'));
            }


            $card = $this->cardRepository->getActiveCard($user, $card);


            $card_info = [
                'fullname' => $user->name,
                'phone' => $user->phone,
                'email' => $user->email,
                'card_number' => $card['barcode'],
                'loyalty_points_balance' => $card['loyalty_points_balance'],
                'wallet_balance' => $card['wallet_balance'],
                'type' => $card['type']
            ];
        } else {
            $card_info = null;
        }

        return $this->responseData(([
            'coupon_code' => $cartDetails["coupon_codes"],
            'card_info' => $card_info ?? null,
            'subtotal' => $cartDetails["subtotal"],
            'lines' => $cartDetails["lines"],
        ]));
    }
}
