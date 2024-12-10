<?php

namespace App\Entities;


class MovieCastsEntity extends Entity
{

    public $entity = "Movie Casts";
    public $tableName = "movie_casts";
    public $slug = "movie-casts";


    public function fields(){

        $this->addField("name" , ["container" => 'col-span-7', 'required' => true]);
        $this->addField("image" , ["container" => 'col-span-7', 'required' => true]);


        return $this->fields;
    }

    public function columns(){

        $this->addColumn("name" , ["container" => 'col-span-7']);
        $this->addField("image" , ["container" => 'col-span-7', 'required' => true]);


        return $this->columns;
    }


}
