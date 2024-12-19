<?php

namespace App\Entities;

use twa\cmsv2\Entities\Entity;

class PriceGroupZonesEntity extends Entity
{

    public $entity = "Price Group Zones";
    public $tableName = "price_group_zones";
    public $slug = "price-group-zones";

    public $gridRules = [
        [
            "operation" => "delete",
            "action" => "disabled",
            "condition" => [
                "field" => 'default' ,
                "operand" => '=' ,
                "value" => 1
            ]
        ],
        // [
        //     "operation" => "edit",
        //     "action" => "disabled",
        //     "condition" => [
        //         "field" => 'default' ,
        //         "operand" => '=' ,
        //         "value" => 1
        //     ]
        // ],
        [
            "operation" => "selection",
            "action" => "disabled",
            "condition" => [
                "field" => 'default' ,
                "operand" => '=' ,
                "value" => 1
            ]
        ]
    ];

    public $params = [
        'pagination' => 20,
    ];

    public function fields(){

        $this->addField("label" , ["container" => 'col-span-7', 'required' => true]);
        $this->addField("color" , ["container" => 'col-span-7']);
        $this->addField("price" , ["container" => 'col-span-7']);
        $this->addField("price_groups" , ["container" => 'col-span-7', 'required' => true]);
        $this->addField("default" , ["container" => 'col-span-7 hidden']);

        $this->addField("price_settings" , ["container" => 'col-span-7']);

        return $this->fields;
    }

    public function columns(){
        $this->addColumn("label" , ["container" => 'col-span-7']);
        $this->addColumn("color" , ["container" => 'col-span-7']);
        $this->addColumn("price" , ["container" => 'col-span-7']);
        $this->addColumn("price_groups" , ["container" => 'col-span-7']);
        $this->addColumn("default" , ["container" => 'col-span-7']);

        return $this->columns;
    }

}
