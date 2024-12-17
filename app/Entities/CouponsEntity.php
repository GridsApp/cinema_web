<?php

namespace App\Entities;

use twa\cmsv2\Entities\Entity;

class CouponsEntity extends Entity
{

    public $entity = "Coupons";
    public $tableName = "coupons";
    public $slug = "coupons";


    public $params = [
        'pagination' => 20,
    ];

    public function fields(){

        $this->addField("code" , ["container" => 'col-span-6', 'required' => true]);
        $this->addField("percentage" , ["container" => 'col-span-6', 'required' => true]);
        $this->addField("flat" , ["container" => 'col-span-12', 'required' => true]);
    

        return $this->fields;
    }

    public function columns(){
        $this->addColumn("code");
        $this->addColumn("percentage");
        $this->addColumn("flat");
    
        return $this->columns;
    }


}
