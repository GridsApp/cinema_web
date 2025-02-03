<?php

namespace App\Http\Controllers\WEBSITE;

use App\Http\Controllers\Controller;
use App\Interfaces\CartRepositoryInterface;
use Illuminate\Http\Request;

class CartController extends Controller
{

    private CartRepositoryInterface $cartRepository;

    public function __construct()
    {

        $this->cartRepository = app(CartRepositoryInterface::class);
    }

    // public function createCart()
    // {
    //     $user = session('user');
    //     try {

    //         $cart = $this->cartRepository->createCart($user->id, 'USER', 3);
  

    //         dd($cart);
    //     } catch (\Exception $th) {
    //         // return  $this->response(notification()->error("Error", $th->getMessage()));
    //     }
    // }


    public function addSeatsToCart(Request $request)
    {
        $selectedSeat = $request->input('selectedSeat'); 

     
        // Handle the seat logic
        // dd("Selected Seat: " . $selectedSeat); // You can replace this with your actual logic

        // Add the selected seat to the cart or perform other operations here
    }
    // public function addSeatsToCart($selectedSeat)
    // {

    //     dd("here");
    //     // $form_data = clean_request([]);
    //     // $check = $this->validateRequiredFields($form_data, ['cart_id', 'seats', 'movie_show_id']);

    //     // if ($check) {
    //     //     return $this->response($check);
    //     // }

    //     $user = request()->user;
    //     $user_type = request()->user_type;

    //     // try {
    //     //     $this->cartRepository->checkCart($form_data['cart_id'], $user->id, $user_type);
    //     // } catch (\Exception $th) {
    //     //     return $this->response(notification()->error('Cart is Expired', $th->getMessage()));
    //     // }

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

    //     if (!is_array($form_data['seats']) || empty($form_data['seats'])) {
    //         return $this->response(notification()->error('Invalid seat data', 'Seats must be an array and not empty'));
    //     }


    //     try {
    //         $seats = $this->theaterRepository->getSeatsFromTheaterMap($theater_map, $form_data['seats']);
    //     } catch (\Exception $th) {
    //         return $this->response(notification()->error('Error getting seats', $th->getMessage()));
    //     }

    //     $reserved_seats = $this->cartRepository->getReservedSeats($form_data['movie_show_id']);

    //     if ($seats->pluck('code')->intersect($reserved_seats)->count() > 0) {
    //         return $this->response(notification()->error('Seats Alredy Reserved', 'Seats Alredy Reserved'));
    //     }


    //     try {
    //         DB::beginTransaction();

    //         foreach ($seats as $seat) {

    //             $this->cartRepository->addSeatToCart($form_data['cart_id'], $seat['code'], $movie_show, $seat['zone']);
    //         }

    //         DB::commit();
    //     } catch (\Exception $th) {

    //         DB::rollBack();
    //         return $this->response(notification()->error('Error adding seats to cart', $th->getMessage()));
    //     }

    //     return $this->response(notification()->success('Seats added to the cart successfully', 'Seats added successfully'));
    // }


    // public function removeSeatFromCart()
    // {
    //     $form_data = clean_request([]);
    //     $check = $this->validateRequiredFields($form_data, ['cart_id', 'seat', 'movie_show_id']);

    //     if ($check) {
    //         return $this->response($check);
    //     }
    //     $user = request()->user;
    //     $user_type = request()->user_type;

    //     try {
    //         $this->cartRepository->checkCart($form_data['cart_id'], $user->id, $user_type);
    //     } catch (\Exception $th) {
    //         return $this->response(notification()->error('Cart is Expired', $th->getMessage()));
    //     }
    //     try {
    //         $this->cartRepository->removeSeatFromCart($form_data['cart_id'], $form_data['seat'], $form_data['movie_show_id']);
    //         return $this->response(notification()->success('Seat removed successfully', 'Seat removed successfully'));
    //     } catch (\Exception $e) {
    //         return $this->response(notification()->error('Error removing seat', $e->getMessage()));
    //     }
    // }
}
