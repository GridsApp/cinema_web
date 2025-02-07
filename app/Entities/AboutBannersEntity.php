<?php

namespace App\Entities;

use twa\cmsv2\Entities\Entity;
class AboutBannersEntity extends Entity
{

    public $entity = "About Banner";
    public $tableName = "about_banners";
    public $slug = "about-banners";


    public $params = [
        'pagination' => 20,
    ];

    public function fields(){

        $this->addField("image" , ["container" => 'col-span-12']);
        $this->addField("title" , ["container" => 'col-span-12','translatable'=>true]);
        $this->addField("description" , ["container" => 'col-span-12','translatable'=>true]);
        $this->addField("cta_link" , ["container" => 'col-span-12']);
        $this->addField("cta_label" , ["container" => 'col-span-12','translatable'=>true]);
        $this->addField("position" , ["container" => 'col-span-12']);

      
        return $this->fields;
    }

    public function columns(){
        $this->addColumn("image");  
        return $this->columns;
    }


   

}
