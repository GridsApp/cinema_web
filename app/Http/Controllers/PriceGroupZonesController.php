<?php

namespace App\Http\Controllers;

use App\Models\PriceGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class PriceGroupZonesController extends Controller
{

    public function render($price_group_id)
    {


        $price_group= PriceGroup::whereNull('deleted_at')->where('id',$price_group_id)->firstOrFail();

        $route = "/".Route::getRoutes()->getByName('price-group-zones.update')->uri();

        $route = str($route)->replace([ "{id}" , "{zone_id}" ] , [$price_group_id , "{id}"])->toString();




        $table =  (new \twa\uikit\Classes\Table\TableData('Price Group Zones ', 'price_group_zones'))

        ->selects(['id'])
            ->addCondition('where', 'price_group_id', $price_group_id)
            ->addColumn("Label", "label", \twa\uikit\Classes\ColumnTypes\DefaultType::class,   \twa\uikit\Classes\ColumnOperationTypes\DefaultOperationType::class, ['label'])
            ->addColumn("Condensed Label", "condensed_label", \twa\uikit\Classes\ColumnTypes\DefaultType::class,   \twa\uikit\Classes\ColumnOperationTypes\DefaultOperationType::class, ['condensed_label'])
            ->addColumn("Color", "color", \twa\uikit\Classes\ColumnTypes\DefaultType::class,   \twa\uikit\Classes\ColumnOperationTypes\DefaultOperationType::class, ['color'])
            ->addColumn("Default", "default", \twa\uikit\Classes\ColumnTypes\DefaultType::class,   \twa\uikit\Classes\ColumnOperationTypes\DefaultOperationType::class, ['default'])
            ->addTableOperation("Add Zone", route('price-group-zones.create' , ['id' => $price_group_id]), '<i class="fa-solid fa-plus"></i>')

            ->addRowOperation("Edit Zone", $route, '<i class="fa-solid fa-plus"></i>');


        $table = $table->get();

        

        return view('pages.price-group-zones', ['table' => $table,'price_group'=>$price_group]);
    }

    public function createZone($price_group_id){


        $price_group= PriceGroup::whereNull('deleted_at')->where('id',$price_group_id)->firstOrFail();

        return view('pages.price-group-zone-create' , ['price_group' => $price_group , 'zone_id' => null]);

    }

    public function editZone($price_group_id , $zone_id){
        $price_group= PriceGroup::whereNull('deleted_at')->where('id',$price_group_id)->firstOrFail();

        return view('pages.price-group-zone-create' , ['price_group' => $price_group , 'zone_id' => $zone_id]);
    }
}
