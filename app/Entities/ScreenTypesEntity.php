<?php

namespace App\Entities;
use twa\cmsv2\Entities\Entity;

class ScreenTypesEntity extends Entity
{

    public $entity = "Screen Types";
    public $tableName = "screen_types";
    public $slug = "screen-types";


    public function fields()
    {

        $this->addField("label", ["container" => 'col-span-7', 'required' => true  ]);



        return $this->fields;
    }

    public function columns() {

        $this->addColumn('label' );

        return $this->columns;
    }
}
