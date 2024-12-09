<?php

namespace App\Entities;


class SlideshowsEntity extends Entity
{

    public $entity = "Slideshows";
    public $tableName = "slideshows";
    public $slug = "slideshows";


    public $params = [
        'pagination' => 20,
    ];

    public function fields(){

        $this->addField("label" , ["container" => 'col-span-12', 'required' => true,'translatable'=>true]);
        $this->addField("text" , ["container" => 'col-span-12','translatable'=>true]);
        $this->addField("image" , ["container" => 'col-span-12', 'required' => true]);
        $this->addField("cta_label" , ["container" => 'col-span-6','translatable'=>true]);
        $this->addField("cta_link" , ["container" => 'col-span-6','translatable'=>true]);

        return $this->fields;
    }

    public function columns(){
        $this->addColumn("image");
        $this->addColumn("label",['translatable'=>true]);
        
        return $this->columns;
    }


}
