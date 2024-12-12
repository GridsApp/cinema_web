<?php

namespace App\Entities;


class ReservedSeatsEntity extends Entity
{

    public $entity = "Reserved Seats";
    public $tableName = "reserved_seats";
    public $slug = "reserved_seats";

    public $params = [
        'pagination' => 20
    ];


    public function fields()
    {

        $this->addField("movie_show_id", ["container" => 'col-span-7', 'required' => true]);
        $this->addField("seat", ["container" => 'col-span-7', 'required' => true]);

        return $this->fields;
    }

    public function columns()
    {
        $this->addColumn("movie_show_id");
        $this->addColumn("seat");

        return $this->columns;
    }
}
