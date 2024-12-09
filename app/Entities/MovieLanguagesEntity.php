<?php

namespace App\Entities;


class MovieLanguagesEntity extends Entity
{

    public $entity = "Movie Languages";
    public $tableName = "movie_languages";
    public $slug = "movie-languages";


    public function fields(){

        $this->addField("label" , ["container" => 'col-span-7', 'required' => true]);


        return $this->fields;
    }

    public function columns(){
        return $this->columns;
    }


}
