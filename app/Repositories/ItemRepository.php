<?php

namespace App\Repositories;

use App\Interfaces\CartRepositoryInterface;
use App\Interfaces\ItemRepositoryInterface;
use App\Models\CartSeat;
use App\Models\Item;
use App\Models\Theater;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class ItemRepository implements ItemRepositoryInterface
{

    // private CartRepositoryInterface $cartRepository;




    // public function __construct(CartRepositoryInterface $cartRepository)
    // {
    //     $this->cartRepository = $cartRepository;

    // }


    public function getItemById($item_id)
    {
        try {

            return Item::where('id', $item_id)->whereNull('deleted_at')->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new Exception($e->getMessage());
        }
        return $item;
    }
    public function getItemsById($item_ids)
    {

        try {

            return Item::whereIn('id', $item_ids)->whereNull('deleted_at')->get();
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e->getMessage());
        }

        return $item;
    }

    public function getCartMovieScreenType($cart_id)
    {

        try {
            $cart_seat_screen_type = CartSeat::whereNull('deleted_at')
                ->where('cart_id', $cart_id)
                ->pluck('screen_type_id');


            return $cart_seat_screen_type;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    public function getItems($branch_id, $cart_id = null)
    {


       $query = Item::whereNull('deleted_at')->where('branch_id', $branch_id);

        if ($cart_id) {
            $screen_ids = $this->getCartMovieScreenType($cart_id);
            $query->where(function ($query) use ($screen_ids) {
                $query->where(function ($q) use ($screen_ids) {
                    foreach ($screen_ids as $screen_id) {
                        $q->orWhere(function ($q1) use ($screen_id) {
                            $q1->where('screen_type_id', 'LIKE', '%"' . $screen_id . '"%');
                            $q1->orWhere('screen_type_id', 'LIKE', "%'" . $screen_id . "'%");
                        });
                    }
                });
                $query->orWhereNull('screen_type_id');
            });

          
        }


        $items = $query->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'label' => $item->label,
                'price' => currency_format($item->price),
                'image' => get_image($item->image),
            ];
        });

        return $items;
    }
}
