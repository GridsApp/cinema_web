<?php

namespace App\Entities;


class MovieShowTheatersEntity extends Entity
{

    public $entity = "Movie Show Theaters";
    public $tableName = "movie_show_theaters";
    public $slug = "movie-show-theater";

    public $params = [
        'pagination' => 20
    ];


    public function fields()
    {

        $this->addField("movie_show_id", ["container" => 'col-span-7', 'required' => true]);
        $this->addField("theater_map", ["container" => 'col-span-7', 'required' => true]);

        return $this->fields;
    }

    public function columns()
    {
        $this->addColumn("movie_show_id", ["container" => 'col-span-7', 'required' => true]);

        return $this->columns;
    }
}
