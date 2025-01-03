<?php

namespace App\Entities;
use twa\cmsv2\Entities\Entity;

class UserSessionsEntity extends Entity
{

    public $entity = "User Sessions";
    public $tableName = "user_sessions";
    public $slug = "user-sessions";


    public $params = [
        'pagination' => 20,
    ];

    public function fields()
    {

        $this->addField("pos_user_id", ["container" => 'col-span-6', 'required' => true]);
        $this->addField("type", ["container" => 'col-span-6', 'required' => true]);
 
        return $this->fields;
    }

    public function columns()
    {
        $this->addColumn("pos_user_id");
        $this->addColumn("type");
 
      
        return $this->columns;
    }
}
