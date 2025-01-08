<?php

namespace App\Entities;

use twa\cmsv2\Entities\Entity;

class MovieReviewsEntity extends Entity
{

    public $entity = "Movie Reviews";
    public $tableName = "movie_reviews";
    public $slug = "movie-reviews";

    public $params = [
        'pagination' => 20,
    ];

    public function fields(){

        $this->addField("user_id" , ["container" => 'col-span-6', 'required' => true]);
        $this->addField("movie" , ["container" => 'col-span-6', 'required' => true]);
        $this->addField("rate" , ["container" => 'col-span-12', 'required' => true]);
        $this->addField("comment" , ["container" => 'col-span-12']);
        
        return $this->fields;
    }

    public function columns(){
        $this->addColumn("user_id");
        $this->addColumn("movie");
        $this->addColumn("rate");
        $this->addColumn("comment");
        
        return $this->columns;
    }


}
