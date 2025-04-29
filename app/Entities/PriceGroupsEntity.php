<?php

namespace App\Entities;

use Illuminate\Support\Facades\Route;
use twa\cmsv2\Entities\Entity;

class PriceGroupsEntity extends Entity
{

    public $entity = "Price Groups";
    public $tableName = "price_groups";
    public $slug = "price-groups";
    public $params = [
        'pagination' => 20,
        'auto_create' => [
            'entity' => 'price-groups-zones',
            'values' => [
                 'label' => 'Default',
                 'condensed_label' => 'Default',
                 'color' => '#00b90f',
                 'default' => 1,
                 'price_group_id' => '{id}'
            ]
         ]
    ];

    public function setRowOperations()
    {


        $route = "/".Route::getRoutes()->getByName('price-group-zones')->uri();


        $this->setRowOperation("View Zones" , $route , '<i class="fa-solid fa-eye"></i>');
    }


    public function fields(){

        $this->addField("label" , ["container" => 'col-span-7', 'required' => true]);
    
        return $this->fields;
    }

    public function columns(){
        $this->addColumn("label" );
        return $this->columns;
    }


}
