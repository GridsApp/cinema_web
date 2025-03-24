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

    public function fields(){

        $this->addField("image" , ["container" => 'col-span-6', 'required' => true]);
        $this->addField("label" , ["container" => 'col-span-6', 'required' => true]);
        $this->addField("price" , ["container" => 'col-span-12', 'required' => true]);
        $this->addField("branch" , ["container" => 'col-span-12', 'required' => true]);
        $this->addField("key" , ["container" => 'col-span-12', 'required' => true]);
    
        return $this->fields;
    }

    public function columns(){
        $this->addColumn("image" );
        $this->addColumn("label" );
        $this->addColumn("price" );
        return $this->columns;
    }


}
