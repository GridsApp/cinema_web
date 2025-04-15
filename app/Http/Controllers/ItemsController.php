<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\PriceGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ItemsController extends Controller
{

    public function render()
    {

      
        $table_route = "/" . Route::getRoutes()->getByName('items.create')->uri();
      
        // dd($table_route);

        $route = "/" . Route::getRoutes()->getByName('item.edit')->uri();

    
        $table =  (new \twa\uikit\Classes\Table\TableData('Items ', 'items'))

            ->setAffectedOnDeletion('family_group_id')
            ->selects(['id' , 'family_group_id'])
         
            ->addColumn("Image", "image", \twa\uikit\Classes\ColumnTypes\Image::class,   \twa\uikit\Classes\ColumnOperationTypes\DefaultOperationType::class, ['image'])
            ->addColumn("Label", "label", \twa\uikit\Classes\ColumnTypes\DefaultType::class,   \twa\uikit\Classes\ColumnOperationTypes\DefaultOperationType::class, ['label'])
            // ->addColumn("Price", "price", \twa\uikit\Classes\ColumnTypes\DefaultType::class,   \twa\uikit\Classes\ColumnOperationTypes\DefaultOperationType::class, ['price'])
            ->addRowOperation("Edit ", $route, '<i class="fa-solid fa-plus"></i>' , ['family_group_id'])

            ->addTableOperation("Add new record ", $table_route, '<i class="fa-solid fa-plus"></i>')


            ->groupBy('family_group_id')
            ->get();

        return view('pages.items', ['table' => $table ]);


    }
    public function createItem()
    {

        $family_group_id = null;

        return view('pages.items-create' , compact('family_group_id'));
    }
    
    public function editItem($family_group_id)
    {


        // $item = Item::whereNull('deleted_at')->where('family_group_id', $family_group_id)->firstOrFail();
        return view('pages.items-create', compact('family_group_id'));
    }
    
    
    // public function editZone($price_group_id , $zone_id){
    //     $price_group= PriceGroup::whereNull('deleted_at')->where('id',$price_group_id)->firstOrFail();

    //     return view('pages.price-group-zone-create' , ['price_group' => $price_group , 'zone_id' => $zone_id]);
    // }
}
