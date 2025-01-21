<?php

namespace App\Entities;

use twa\cmsv2\Entities\Entity;
class AboutParagraphsEntity extends Entity
{

    public $entity = "About Paragraphs";
    public $tableName = "about_paragraphs";
    public $slug = "about-paragraphs";


    public $params = [
        'pagination' => 20,
    ];

    public function fields(){

        $this->addField("content" , ["container" => 'col-span-12','translatable'=>true]);
      
        return $this->fields;
    }

    public function columns(){
        $this->addColumn("content");  
        return $this->columns;
    }


}
