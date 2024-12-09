<?php

namespace App\Entities;


class MovieAgeRatingsEntity extends Entity
{

    public $entity = "Movie Age Ratings";
    public $tableName = "movie_age_ratings";
    public $slug = "movie-age-ratings";


    public function fields(){

        $this->addField("label" , ["container" => 'col-span-7', 'required' => true]);


        return $this->fields;
    }

    public function columns(){
        return $this->columns;
    }


}
