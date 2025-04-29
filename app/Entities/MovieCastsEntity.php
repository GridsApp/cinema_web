<?php

namespace App\Entities;

use twa\cmsv2\Entities\Entity;

class MovieCastsEntity extends Entity
{

    public $entity = "Movie Casts";
    public $tableName = "movie_casts";
    public $slug = "movie-casts";


    public function fields(){

        $this->addField("name" , ["container" => 'col-span-7', 'required' => true]);
        $this->addField("image" , ["container" => 'col-span-7']);


        return $this->fields;
    }

    public function columns(){

        $this->addColumn("name");
        $this->addColumn("image");


        return $this->columns;
    }


}
