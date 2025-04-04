<?php

namespace App\Repositories;


use App\Interfaces\ItemRepositoryInterface;
use App\Models\BranchItem;
use App\Models\CartSeat;
use App\Models\Item;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class ItemRepository implements ItemRepositoryInterface
{


    public function getItemById($item_id)
    {

        try {

            $item = BranchItem::query()
            ->select('branch_items.id as id' , 'branch_items.price' , 'items.label' , 'items.image' , 'items.screen_type_id')
            ->whereNull('branch_items.deleted_at')
            ->where('branch_items.hide' , '!=' , 1)
            ->where('branch_items.id' , $item_id)
            ->join('items' , function($join){
               return $join->on('branch_items.item_id' , 'items.id')
                ->whereNull('items.deleted_at');
            })
            ->firstOrFail();
              
            return $item;

            return Item::where('id', $item_id)->whereNull('deleted_at')->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new Exception($e->getMessage());
        }
        return $item;
    }
    public function getItemsById($item_ids)
    {

        try {

            return BranchItem::query()
            ->select('branch_items.id as id' , 'branch_items.price' , 'items.label' , 'items.image' , 'items.screen_type_id')
            ->whereNull('branch_items.deleted_at')
            ->where('branch_items.hide' , '!=' , 1)
            ->whereIn('branch_items.id' , $item_ids)
            ->join('items' , function($join){
               return $join->on('branch_items.item_id' , 'items.id')
                ->whereNull('items.deleted_at');
            })
            ->get();
              
            
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


    $query = BranchItem::query()
        ->select('branch_items.id as id' , 'branch_items.price' , 'items.label' , 'items.image' , 'items.screen_type_id')
        ->whereNull('branch_items.deleted_at')
        ->where('branch_items.hide' , '!=' , 1)
        ->where('branch_items.branch_id' , $branch_id)
      

        ->join('items' , function($join){
            return $join->on('branch_items.item_id' , 'items.id')
             ->whereNull('items.deleted_at');
         });

        if ($cart_id) {
            $screen_ids = $this->getCartMovieScreenType($cart_id);
            // dd($screen_ids);

            $query->where(function ($query) use ($screen_ids) {
                $query->where(function ($q) use ($screen_ids) {
                    foreach ($screen_ids as $screen_id) {
                        $q->orWhere(function ($q1) use ($screen_id) {
                            $q1->where('items.screen_type_id', 'LIKE', '%"' . $screen_id . '"%');
                            $q1->orWhere('items.screen_type_id', 'LIKE', "%'" . $screen_id . "'%");
                        });
                    }
                });
                $query->orWhereNull('items.screen_type_id');
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
