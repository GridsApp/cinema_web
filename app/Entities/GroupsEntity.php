<?php

namespace App\Entities;

use twa\cmsv2\Entities\Entity;
class GroupsEntity extends Entity
{

    public $entity = "Groups";
    public $tableName = "groups";
    public $slug = "groups";


    public $params = [
        'pagination' => 20,
    ];

    public function fields(){

        $this->addField("label" , ["container" => 'col-span-12']);
        $this->addField("key" , ["container" => 'col-span-12']);
    
        return $this->fields;
    }

    public function columns(){
        $this->addColumn("label");  
        $this->addColumn("key");  
        return $this->columns;
    }


   

}
