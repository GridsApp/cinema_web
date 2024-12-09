<?php

namespace App\Entities;


class SystemsEntity extends Entity
{

    public $entity = "Systems";
    public $tableName = "systems";
    public $slug = "systems";


   

    public $params = [
        'pagination' => 20,
    ];


    public function fields(){

        $this->addField("label" , ["container" => 'col-span-7']);
     

        return $this->fields;
    }

    public function columns(){

        $this->addColumn("label" );
   
        return $this->columns;
    }


}
