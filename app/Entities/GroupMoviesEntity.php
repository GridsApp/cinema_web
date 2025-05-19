<?php

namespace App\Entities;

use twa\cmsv2\Entities\Entity;
class GroupMoviesEntity extends Entity
{

    public $entity = "Group Movies";
    public $tableName = "group_movies";
    public $slug = "group-movies";


    public $params = [
        'pagination' => 20,
    ];

    public function fields(){

        $this->addField("group_id" , ["container" => 'col-span-12']);
        $this->addField("movie" , ["container" => 'col-span-12']);
     
      
        return $this->fields;
    }

    public function columns(){
        $this->addColumn("movie");  
        $this->addColumn("group_id");  
        return $this->columns;
    }


   

}
