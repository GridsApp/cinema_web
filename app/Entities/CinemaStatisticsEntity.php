<?php

namespace App\Entities;

use twa\cmsv2\Entities\Entity;
class CinemaStatisticsEntity extends Entity
{

    public $entity = "Cinema Statistics";
    public $tableName = "cinema_statistics";
    public $slug = "cinema-statistics";


    public $params = [
        'pagination' => 20,
    ];

    public function fields(){

        $this->addField("label" , ["container" => 'col-span-12','translatable'=>true]);
        $this->addField("number" , ["container" => 'col-span-12']);
      
        return $this->fields;
    }

    public function columns(){
        $this->addColumn("label");  
        $this->addColumn("number");  
        return $this->columns;
    }


}
