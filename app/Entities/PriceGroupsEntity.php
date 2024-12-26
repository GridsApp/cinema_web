<?php

namespace App\Entities;

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
                 'color' => '#6b7280',
                 'default' => 1,
                 'price_group_id' => '{id}'
            ]
         ]
    ];

    public function fields(){

        $this->addField("label" , ["container" => 'col-span-7', 'required' => true]);
    
        return $this->fields;
    }

    public function columns(){
        $this->addColumn("label" );
        return $this->columns;
    }


}
