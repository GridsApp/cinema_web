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
 
    public function createCart()
    {

        // $user = request()->user;
        $user = session('user');
        $user_type = request()->user_type;

        $form_data = clean_request([]);
        $system_id = get_system_from_type($user_type);

        try {
            $cart = $this->cartRepository->createCart($user->id, $user_type, $system_id);
        } catch (\Exception $th) {
            // return  $this->response(notification()->error("Error", $th->getMessage()));
        }

        

        // return $this->responseData([
        //     'cart_id' => $cart->id,
        //     'timezone' => config('app.timezone'),
        //     'expires_at' => $cart->expires_at
        // ]);
        // return $this->responseData([
        //     'cart_id' => $cart->id,
        //     'timezone' => config('app.timezone'),
        //     'expires_at' => $cart->expires_at
        // ], notification()->success('Cart created', 'Cart created'));
    }
}
