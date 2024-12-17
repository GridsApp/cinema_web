<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Interfaces\CardRepositoryInterface;
use App\Interfaces\CartRepositoryInterface;
use App\Interfaces\ItemRepositoryInterface;

use App\Interfaces\MovieShowRepositoryInterface;
use App\Interfaces\TheaterRepositoryInterface;
use App\Interfaces\ZoneRepositoryInterface;
use App\Models\Coupon;

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

    public function __construct(
        CartRepositoryInterface $cartRepository,
        MovieShowRepositoryInterface $movieShowRepository,
        TheaterRepositoryInterface $theaterRepository,
        ItemRepositoryInterface $itemRepository,
        ZoneRepositoryInterface $zoneRepository,
        CardRepositoryInterface $cardRepository
    ) {
        $this->cartRepository = $cartRepository;
        $this->movieShowRepository = $movieShowRepository;
        $this->theaterRepository = $theaterRepository;
        $this->itemRepository = $itemRepository;
        $this->zoneRepository = $zoneRepository;
        $this->cardRepository = $cardRepository;
    }


    public function createCart()
    {


        $user = request()->user;
        $user_type = request()->user_type;



        $form_data = clean_request([]);
        $check = $this->validateRequiredFields($form_data, ['system_id']);

        if ($check) {
            return $this->response($check);
        }

        try {
            $this->cartRepository->getSystemById($form_data['system_id']);
        } catch (\Throwable $th) {
            return $this->response(notification()->error('System not found', $th->getMessage()));
        }

        try {
            $cart = $this->cartRepository->createCart($user->id, $user_type, $form_data['system_id']);
        } catch (\Exception $th) {
            return  $this->response(notification()->error("Error", $th->getMessage()));
        }

        return $this->responseData([
            'cart_id' => $cart->id,
            'expires_at' => $cart->expires_at
        ]);
    }


    public function expireCart()
    {

        $form_data = clean_request([]);
        $check = $this->validateRequiredFields($form_data, ['cart_id']);

        if ($check) {
            return $this->response($check);
        }
        $cart_id = $form_data['cart_id'];
        try {
            $this->cartRepository->expireCart($cart_id);
            return $this->response(notification()->success('Cart Expired successfully', 'Cart Expired successfully'));
            
        } catch (\Exception $th) {
            return  $this->response(notification()->error("Error", $th->getMessage()));
        }
    }
    public function addItemCart()
    {


        $form_data = clean_request([]);

        if (!$form_data['cart_id'] || !$form_data['item_id']) {
            return $this->response(notification()->error('Missing form data cart_id , item_id', 'Missing form data cart_id , item_id'));
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
            // dd($cart);
        } catch (\Throwable $th) {
            return $this->response(notification()->error('Item not found', $th->getMessage()));
        }


        try {
            $this->cartRepository->addItemToCart($form_data['cart_id'], $form_data['item_id']);
            return $this->response(notification()->success('Item added  to the cart successfully', 'Item added successfully'));
        } catch (\Exception $e) {
            return $this->response(notification()->error('Error adding item to cart', $e->getMessage()));
        }
    }
    public function addSeatsCart()
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


        // try {
        //     $seats = $this->theaterRepository->getSeatsFromTheaterMap($theater_map, $form_data['seats']);
        //     // dd($seats);
        // } catch (\Exception $th) {
        //     return $this->response(notification()->error('seat not found', $th->getMessage()));
        // }
        // dd($seats);
        try {
            $seats = $this->theaterRepository->getSeatsFromTheaterMap($theater_map, $form_data['seats']);

            if ($seats->isEmpty()) {
                return $this->response(notification()->error('Invalid seat data', 'No valid seats found.'));
            }

            foreach ($seats as $seat) {
                // dd($seat['code']);
                $this->cartRepository->addSeatToCart($form_data['cart_id'], $seat['code'], $form_data['movie_show_id'], $seat['zone']);
            }
        } catch (\Exception $th) {
            return $this->response(notification()->error('Error adding seats to cart', $th->getMessage()));
        }
        return $this->response(notification()->success('Seats added to the cart successfully', 'Seats added successfully'));
    }


    // public function addSeatCart()
    // {
    //     $form_data = clean_request([]);
    //     $check = $this->validateRequiredFields($form_data, ['cart_id', 'seats', 'movie_show_id']);

    //     if ($check) {
    //         return $this->response($check);
    //     }

    //     $user = request()->user;
    //     $user_type = request()->user_type;

    //     try {
    //         $this->cartRepository->checkCart($form_data['cart_id'], $user->id , $user_type);
    //     } catch (\Exception $th) {
    //         return $this->response(notification()->error('Cart is Expired', $th->getMessage()));
    //     }
    //     try {
    //         $movie_show = $this->movieShowRepository->getMovieShowById($form_data['movie_show_id']);
    //     } catch (\Exception $th) {
    //         return $this->response(notification()->error('Movie Show Not found', $th->getMessage()));
    //     }

    //     try {
    //         $theater_map = $this->theaterRepository->getTheaterMap($movie_show->theater_id);
    //     } catch (\Exception $th) {
    //         return $this->response(notification()->error('Theater Not found', $th->getMessage()));
    //     }
    //     // $movie_show = $this->movieShowRepository->getMovieShowById($form_data['movie_show_id']);


    //     try {
    //         $seat = $this->theaterRepository->getSeatFromTheaterMap($theater_map, $form_data['seats']);
    //     } catch (\Exception $th) {
    //         return $this->response(notification()->error('seat not found', $th->getMessage()));
    //     }


    //     try {
    //         $this->cartRepository->addSeatToCart($form_data['cart_id'], $form_data['seats'], $form_data['movie_show_id'], $seat['zone']);
    //     } catch (\Exception $th) {
    //         return $this->response(notification()->error('Error adding seat to car', $th->getMessage()));
    //     }


    //     return $this->response(notification()->success('Seat added to the cart successfully', 'Seat added successfully'));
    // }
    public function addTopupToCart()
    {
        $form_data = clean_request([]);
        $check = $this->validateRequiredFields($form_data, ['cart_id', 'amount']);

        if ($check) {
            return $this->response($check);
        }


        //GET FROM SETTINGS
        $minimum_recharge_amount = 10;
        $maximum_recharge_amount = 50;


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
        //   dd( $cart);

        if (!$cart->user_id && !$cart->card_number) {
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
        $cart_id = request()->input('cart_id');

        if (!$cart_id) {
            return $this->response(notification()->error('Missing parameters: cart_id ', 'Missing parameters'));
        }

        try {
            $this->cartRepository->removeTopupFromCart($cart_id);
            return $this->response(notification()->success('Top Up removed successfully', 'Top Up removed successfully'));
        } catch (\Exception $e) {
            return $this->response(notification()->error('Error removing Top Up', $e->getMessage()));
        }
    }
    public function removeSeatFromCart()
    {
        $cart_id = request()->input('cart_id');
        $seat = request()->input('seat');
        $movie_show_id = request()->input('movie_show_id');


        if (!$cart_id || !$seat  || !$movie_show_id) {
            return $this->response(notification()->error('Missing parameters: cart_id or seat or Movie show id', 'Missing parameters'));
        }

        try {
            $this->cartRepository->removeSeatFromCart($cart_id, $seat, $movie_show_id);
            return $this->response(notification()->success('Seat removed successfully', 'Seat removed successfully'));
        } catch (\Exception $e) {
            return $this->response(notification()->error('Error removing seat', $e->getMessage()));
        }
    }
    public function removeItemFromCart()
    {
        $cart_id = request()->input('cart_id');
        $item_id = request()->input('item_id');

        if (!$cart_id || !$item_id) {
            return $this->response(notification()->error('Missing parameters: cart_id or Item id', 'Missing parameters'));
        }

        try {

            $this->cartRepository->removeItemFromCart($cart_id, $item_id);

            return $this->response(notification()->success('Item removed successfully', 'Item removed successfully'));
        } catch (\Exception $e) {
            return $this->response(notification()->error('Error removing Item', $e->getMessage()));
        }
    }

    public function addCoupnTocart()
    {
        $form_data = clean_request([]);
        $check = $this->validateRequiredFields($form_data, ['cart_id', 'code']);

        if ($check) {
            return $this->response($check);
        }

        $user = request()->user;
        $user_type = request()->user_type;

        try {

            $coupon = $this->cartRepository->getCouponByCode($form_data['code']);
        } catch (\Throwable $th) {
            return $this->response(notification()->error('Coupon not found', $th->getMessage()));
        }

        try {
            $cart = $this->cartRepository->checkCart($form_data['cart_id'], $user->id, $user_type);
        } catch (\Exception $th) {
            return $this->response(notification()->error('Cart is Expired', $th->getMessage()));
        }


        try {
            $this->cartRepository->addCouponToCart($form_data['cart_id'], $coupon->id);
        } catch (\Exception $th) {
            return $this->response(notification()->error('Error adding coupon to cart', $th->getMessage()));
        }


        return $this->response(notification()->success('Coupon added to the cart successfully', 'Coupon added successfully'));
    }

    public function removeCouponFromCart()
    {
        $cart_id = request()->input('cart_id');

        if (!$cart_id) {
            return $this->response(notification()->error('Missing parameters: cart_id ', 'Missing parameters'));
        }
        try {

            $this->cartRepository->removeCouponFromCart($cart_id);

            return $this->response(notification()->success('Coupon removed successfully', 'Coupon removed successfully'));
        } catch (\Exception $e) {
            return $this->response(notification()->error('Error removing Coupon', $e->getMessage()));
        }
    }

    public function addCardNumberTocart()
    {
        $form_data = clean_request([]);
        $check = $this->validateRequiredFields($form_data, ['cart_id', 'card_number']);

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

            $existing_barcode =  $this->cardRepository->getcardByBarcode($form_data['card_number']);
        } catch (\Exception $e) {
            return $this->response(notification()->error('Card number not found', $e->getMessage()));
        }

        try {
            $this->cartRepository->addCardNumberTocart($form_data['cart_id'], $form_data['card_number']);
        } catch (\Exception $th) {
            return $this->response(notification()->error('Error adding Card Number to cart', $th->getMessage()));
        }


        return $this->response(notification()->success('Card Number added to the cart successfully', 'Card Number added successfully'));
    }

    public function removeCardNumberFromcart()
    {
        $cart_id = request()->input('cart_id');

        if (!$cart_id) {
            return $this->response(notification()->error('Missing parameters: cart_id ', 'Missing parameters'));
        }
        try {
            $this->cartRepository->removeCardNumberFromCart($cart_id);

            return $this->response(notification()->success('Card Number removed successfully', 'Card Number removed successfully'));
        } catch (\Exception $e) {
            return $this->response(notification()->error('Error Removing Card Number', $e->getMessage()));
        }
    }

    public function list()
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

            $cartDetails = $this->cartRepository->getCartDetails($cart);

            return $this->responseData($cartDetails);
        } catch (\Exception $e) {
            return $this->response(notification()->error('Error', $e->getMessage()));
        }
      
    }
}
