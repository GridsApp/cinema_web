<?php

namespace App\Livewire\Website;

use App\Interfaces\CartRepositoryInterface;
use App\Interfaces\ItemRepositoryInterface;
use Livewire\Component;

class ItemSelector extends Component
{
    public $item;
    public $quantity = 0;

    private CartRepositoryInterface $cartRepository;
    private ItemRepositoryInterface $itemRepository;


    public function __construct()
    {
        $this->cartRepository = app(CartRepositoryInterface::class);
        $this->itemRepository = app(ItemRepositoryInterface::class);
    }
    public function mount()
    {
        $this->quantity = session()->get("cart_quantities.{$this->item['id']}", 0);
    }
    
    public function addItemToCart($item_id)
    {
        $cart = session()->get('cart');
        $cart_id = $cart->id;
        $user = session('user');

        try {

            $this->cartRepository->checkCart($cart_id, $user->id, 'USER');
        } catch (\Exception $th) {
        }

        try {

            $this->itemRepository->getItemById($item_id);
        } catch (\Exception $th) {
        }

        try {

            $this->cartRepository->addItemToCart($cart_id, $item_id);

            session()->put('cart', $cart);


            $this->quantity = session()->get("cart_quantities.{$item_id}", 0) + 1;
            session()->put("cart_quantities.{$item_id}", $this->quantity);
            
        } catch (\Exception $e) {
        }

        $this->dispatch('update-cart');
    }



    public function removeItemFromCart($item_id)
    {


        $cart = session()->get('cart');
        $cart_id = $cart->id;

        $user = session('user');

        try {

            $item =  $this->itemRepository->getItemById($item_id);
        } catch (\Exception $th) {
            // return $this->response(notification()->error('Item not found', $th->getMessage()));
        }
        try {

            $this->cartRepository->removeItemFromCart($cart_id, $item_id);
            $this->quantity = max(0, session()->get("cart_quantities.{$item_id}", 0) - 1);
            session()->put("cart_quantities.{$item_id}", $this->quantity);
             // return $this->response(notification()->success('Item removed successfully', 'Item removed successfully'));
        } catch (\Exception $e) {
            return $this->response(notification()->error('Error removing Item', $e->getMessage()));
        }
    }
    public function render()
    {
        return view('livewire.website.item-selector');
    }
}
