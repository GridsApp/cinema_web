<?php

namespace App\Entities;

use twa\cmsv2\Entities\Entity;
class CinemaFoundersEntity extends Entity
{

    public $entity = "Cinema Founders";
    public $tableName = "cinema_founders";
    public $slug = "cinema-founders";


    public $params = [
        'pagination' => 20,
    ];

    public function fields(){

        $this->addField("top_image" , ["container" => 'col-span-6']);
        $this->addField("bottom_image" , ["container" => 'col-span-6']);
        $this->addField("content" , ["container" => 'col-span-6']);
      
        return $this->fields;
    }

    public function columns(){
        $this->addColumn("top_image");  
        $this->addColumn("bottom_image");  
        return $this->columns;
    }


}
