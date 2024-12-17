<?php

namespace App\Entities;

use twa\cmsv2\Entities\Entity;

class MovieFavoritesEntity extends Entity
{

    public $entity = "Movie Favorites";
    public $tableName = "movie_favorites";
    public $slug = "movie-favorites";


    public function fields(){

        $this->addField("user_id" , ["container" => 'col-span-7', 'required' => true]);
        $this->addField("movie" , ["container" => 'col-span-7', 'required' => true]);


        return $this->fields;
    }

    public function columns(){
        return $this->columns;
    }


}
