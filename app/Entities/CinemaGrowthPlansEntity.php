<?php

namespace App\Entities;

use twa\cmsv2\Entities\Entity;
class CinemaGrowthPlansEntity extends Entity
{

    public $entity = "Cinema Growth Plans";
    public $tableName = "cinema_growth_plans";
    public $slug = "cinema-growth-plans";


    public $params = [
        'pagination' => 20,
    ];

    public function fields(){

        $this->addField("image" , ["container" => 'col-span-12']);
        $this->addField("content" , ["container" => 'col-span-6','translatable'=>true]);

      
        return $this->fields;
    }

    public function columns(){
        $this->addColumn("image");  
        $this->addColumn("content");  
        return $this->columns;
    }


}
