<?php

namespace App\Entities;

use twa\cmsv2\Entities\Entity;

class MovieGenresEntity extends Entity
{

    public $entity = "Movie Genres";
    public $tableName = "movie_genres";
    public $slug = "movie-genres";





    public function fields(){

        $this->addField("label" , ["container" => 'col-span-7', 'required' => true,'translatable' => true]);


        return $this->fields;
    }

    public function columns(){
        return $this->columns;
    }


}
