<?php

namespace App\Entities;


class MaritualStatusEntity extends Entity
{

    public $entity = "Maritual Status ";
    public $tableName = "marital_status";
    public $slug = "marital_status";


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
