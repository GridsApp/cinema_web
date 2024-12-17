<?php

namespace App\Entities;

use twa\cmsv2\Entities\Entity;

class DistributorsEntity extends Entity
{

    public $entity = "Distributors";
    public $tableName = "distributors";
    public $slug = "distributors";


    public function fields(){
        $this->addField("label" , ["container" => 'col-span-7' , 'required' => true]);
        // $this->addField("main_image" , ["container" => 'col-span-7' , 'required' => true]);
        return $this->fields;
    }

    public function columns(){

        $this->addColumn("label");
        $this->addColumn("created_at");
        $this->addColumn("updated_at");
        return $this->columns;
    }

}
