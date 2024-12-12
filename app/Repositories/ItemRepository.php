<?php

namespace App\Repositories;

use App\Interfaces\ItemRepositoryInterface;
use App\Models\Item;
use App\Models\Theater;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class ItemRepository implements ItemRepositoryInterface
{


    public function getItemById($item_id)
    {

        try {

            return Item::where('id', $item_id)->whereNull('deleted_at')->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e->getMessage());
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
    public function getItems($branch_id)
    {
        try {
            $items = Item::whereNull('deleted_at')->where('branch_id',$branch_id)->get()->map(function ($item) {
                return [
                    'label' => $item->label,
                    'price' => currency_format($item->price),
                    'image' => get_image($item->image),

                ];
            });
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e->getMessage());
        }

        return $items;
    }
}
