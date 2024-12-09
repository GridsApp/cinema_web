<?php

namespace App\Entities;


class MoviesEntity extends Entity
{

    public $entity = "Movies";
    public $tableName = "movies";
    public $slug = "movies";


    public $form = "pages.form.movie";


    public $params = [
        'pagination' => 20,
        'form' => 'admin.forms.movie-form',

    ];

    public function fields(){



        $this->addField("movie_key" , ["container" => 'col-span-7', 'required' => true]);
        $this->addField("movie_name" , ["container" => 'col-span-7', 'required' => true]);
        $this->addField("condensed_name" , ["container" => 'col-span-7']);
        $this->addField("description" , ["container" => 'col-span-7', 'required' => true]);
        $this->addField("duration" , ["container" => 'col-span-7', 'required' => true]);
        $this->addField("cast" , ["container" => 'col-span-7', 'required' => true]);
        $this->addField("director" , ["container" => 'col-span-7', 'required' => true]);
        $this->addField("genre" , ["container" => 'col-span-7', 'required' => true]);
        $this->addField("age_rating" , ["container" => 'col-span-7', 'required' => true]);

        $this->addField("language" , ["container" => 'col-span-7', 'required' => true]);
        $this->addField("main_image" , ["container" => 'col-span-7', 'required' => true]);
        $this->addField("cover_image" , ["container" => 'col-span-7']);
        $this->addField("youtube_video" , ["container" => 'col-span-7']);
        $this->addField("release_date" , ["container" => 'col-span-7']);
        $this->addField("imdb_rating" , ["container" => 'col-span-7']);
        $this->addField("imdb_vote" , ["container" => 'col-span-7']);





        return $this->fields;
    }

    public function columns(){
        $this->addColumn("main_image" );
        $this->addColumn("cover_image" );
        $this->addColumn('movie_key');
        $this->addColumn("condensed_name");
        $this->addColumn("release_date" );
        $this->addColumn("duration" , ["label" => "Duration (min)"] );
        $this->addColumn("cast" );
        $this->addColumn("director" );


        return $this->columns;


    }


}
