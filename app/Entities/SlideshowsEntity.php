<?php

namespace App\Entities;

use twa\cmsv2\Entities\Entity;
class SlideshowsEntity extends Entity
{

    public $entity = "Slideshows";
    public $tableName = "slideshows";
    public $slug = "slideshows";

    public $enableSorting = true;
    public $sortingCardLabel = "label_en";

    public $params = [
        'pagination' => 20,
    ];

    public function fields(){

        $this->addField("label" , ["container" => 'col-span-12', 'required' => true,'translatable'=>true]);
        $this->addField("text" , ["container" => 'col-span-12','translatable'=>true]);
        $this->addField("image" , ["container" => 'col-span-12', 'required' => true]);
        $this->addField("web_image" , ["container" => 'col-span-12']);
        $this->addField("cta_label" , ["container" => 'col-span-6','translatable'=>true]);
        $this->addField("cta_link" , ["container" => 'col-span-6','translatable'=>true]);

        return $this->fields;
    }

    public function columns(){
        $this->addColumn("image");
        $this->addColumn("label_en",['translatable'=>true]);
        
        return $this->columns;
    }


}
