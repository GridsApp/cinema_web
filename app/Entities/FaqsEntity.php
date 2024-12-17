<?php

namespace App\Entities;

use twa\cmsv2\Entities\Entity;

class FaqsEntity extends Entity
{

    public $entity = "Faqs";
    public $tableName = "faqs";
    public $slug = "faqs";


    public $params = [
        'pagination' => 20,
    ];

    public function fields()
    {

        $this->addField("question", ["container" => 'col-span-7', 'required' => true,'translatable'=>true]);
        $this->addField("answer", ["container" => 'col-span-7', 'required' => true,'translatable'=>true]);


        return $this->fields;
    }

    public function columns()
    {
        $this->addColumn("question",['translatable'=>true]);

        return $this->columns;
    }
}
