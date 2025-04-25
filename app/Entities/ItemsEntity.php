<?php

namespace App\Entities;

use twa\cmsv2\Entities\Entity;

class ItemsEntity extends Entity
{

    public $entity = "Items";
    public $tableName = "items";
    public $slug = "items";


    public $params = [
        'pagination' => 20,
    ];

    public function fields()
    {
        $this->addField("label", ["container" => 'col-span-7', 'required' => true]);
        $this->addField("image", ["container" => 'col-span-7', 'required' => true]);
        $this->addField("screen_type_condition", ["container" => 'col-span-7', 'required' => false]);
        $this->addField("category", ["container" => 'col-span-6', 'required' => true]);
        $this->addField("item_code", ["container" => 'col-span-6', 'required' => true]);



        return $this->fields;
    }

    public function columns()
    {
        $this->addColumn("image");
        $this->addColumn("label");
        $this->addColumn("screen_type_condition");
        return $this->columns;
    }
}
