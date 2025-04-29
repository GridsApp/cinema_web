<?php

namespace App\Entities;

use twa\cmsv2\Entities\Entity;

class MovieDirectorsEntity extends Entity
{

    public $entity = "Movie Directors ";
    public $tableName = "movie_directors";
    public $slug = "movie-directors";


    public function fields(){

        $this->addField("name" , ["container" => 'col-span-7', 'required' => true]);
        return $this->fields;
    }

    public function columns(){
        return $this->columns;
    }


}
