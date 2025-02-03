<?php

namespace App\Livewire\Website;

use App\Interfaces\CartRepositoryInterface;
use Livewire\Attributes\On;
use Livewire\Component;

class CartDetails extends Component
{

  


    public $cart_details;
    private CartRepositoryInterface $cartRepository;
    // private ItemRepositoryInterface $itemRepository;


    public function __construct()
    {
        $this->cartRepository = app(CartRepositoryInterface::class);
        // $this->itemRepository = app(ItemRepositoryInterface::class);
    }
    public function mount()
    {
        $this->cartDetails();
    }
    #[On('update-cart')]
    public function cartDetails()
    {
        $cart = session()->get('cart');
        $cart_id = $cart->id;

     

        $user = session('user');
        // $user_type = request()->user_type;

        try {
            $cart = $this->cartRepository->checkCart($cart_id, $user->id, "USER");
        } catch (\Exception $e) {
            // return $this->response(notification()->error('Error', $e->getMessage()));
        }

        $this->cart_details = $this->cartRepository->getCartDetails($cart);

        // dd($this->cart_details);

        // if ($cartDetails['user_id']) {
        //     try {
        //         $user = $this->userRepository->getUserById($cartDetails['user_id']);
        //     } catch (\Throwable $th) {
        //         // throw new Exception($th->getMessage());
        //     }

        //     // $card = $this->cardRepository->getActiveCard($user);

        //     $card_info = [
        //         'fullname' => $user->name,
        //         'phone' => $user->phone,
        //         'email' => $user->email,
        //         // 'card_number' => $card['barcode'],
        //         // 'loyalty_balance' => $card['loyalty_points_balance'],
        //         // 'wallet_balance' => $card['wallet_balance'],
        //         // 'type' => $card['type']
        //     ];
        // } 
        // else {
        //     $card_info = null;
        // }

        // return $this->responseData([
        //     'coupon_code' => $cartDetails["coupon_codes"],
        //     'card_info' => $card_info ?? null,
        //     'subtotal' => $cartDetails["subtotal"],
        //     'lines' => $cartDetails["lines"],
        // ], notification()->success('Successfully Fetched', 'Fetched successfully.'));
    }
   
    public function render()
    {
        return view('livewire.website.cart-details');
    }
}
