<?php

namespace App\Entities;

use twa\cmsv2\Entities\Entity;

class UserPinsEntity extends Entity
{

    public $entity = "User Pins";
    public $tableName = "user_pins";
    public $slug = "user-pins";


    public $params = [
        'pagination' => 20,
    ];

    public function fields()
    {

        $this->addField("user_id", ["container" => 'col-span-6', 'required' => true]);
        $this->addField("code", ["container" => 'col-span-12']);
        $this->addField("expires_at", ["container" => 'col-span-12', 'required' => false]);


        return $this->fields;
    }

    public function columns()
    {
        $this->addColumn("user_id");
        $this->addColumn("code");
        $this->addColumn("expires_at");


        return $this->columns;
    }
}
