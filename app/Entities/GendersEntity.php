<?php

namespace App\Entities;


class GendersEntity extends Entity
{

    public $entity = "Genders";
    public $tableName = "genders";
    public $slug = "genders";


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
