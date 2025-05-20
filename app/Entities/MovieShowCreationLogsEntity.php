<?php

namespace App\Entities;

use twa\cmsv2\Entities\Entity;

class MovieShowCreationLogsEntity extends Entity
{

    public $entity = "Movie Show Creation Logs";
    public $tableName = "movie_show_creation_logs";
    public $slug = "movie-show-creation-logs";





    public function fields(){

      
        $this->addField("movie" , ["container" => 'col-span-7', 'required' => true]);
        $this->addField("cms_user" , ["container" => 'col-span-7', 'required' => true]);
        $this->addField("date" , ["container" => 'col-span-7', 'required' => true]);

        $this->addField("theater" , ["container" => 'col-span-7', 'required' => true]);
        $this->addField("time" , ["container" => 'col-span-7', 'required' => false]);

        $this->addField("screen_type" , ["container" => 'col-span-7']);
      
      $this->addField("status" , ["container" => 'col-span-7']);
        $this->addField("message" , ["container" => 'col-span-7']);


        return $this->fields;
    }

    public function columns(){
        return $this->columns;
    }


}
