<?php

namespace App\Entities;

use twa\cmsv2\Entities\Entity;
class HomeParagraphBannersEntity extends Entity
{

    public $entity = "Home Paragraph Banners";
    public $tableName = "home_paragraph_banners";
    public $slug = "home-paragraph-banners";


    public $params = [
        'pagination' => 20,
    ];

    public function fields(){

        $this->addField("first_image" , ["container" => 'col-span-12']);
        $this->addField("second_image" , ["container" => 'col-span-12']);
        $this->addField("third_image" , ["container" => 'col-span-12']);
        $this->addField("fourth_image" , ["container" => 'col-span-12']);
        $this->addField("content" , ["container" => 'col-span-12']);
      
        return $this->fields;
    }

    public function columns(){
        $this->addColumn("image");  
        $this->addColumn("second_image");  
        return $this->columns;
    }


}
