<?php

namespace App\Entities;

use twa\cmsv2\Entities\Entity;

class KioskUsersEntity extends Entity
{

    public $entity = "KIOSK Users";
    public $tableName = "kiosk_users";
    public $slug = "kiosk-users";

    public $params = [
        'pagination' => 20,
    ];


    public $conditions = [
        [
            'type' => 'where',
            'column' => 'branches.id',
            'operand' => null,
            'value' => '{branch_id}'
        ]
    ];
    public function fields()
    {


        $this->addField("name", ["container" => 'col-span-7', 'required' => true]);
        $this->addField("username", ["container" => 'col-span-7', 'required' => true]);
        $this->addField("passcode", ["container" => 'col-span-7', 'required' => false]);
        $this->addField("pincode", ["container" => 'col-span-7', 'required' => true]);
        $this->addField("branch", ["container" => 'col-span-7', 'required' => false]);
        $this->addField("access_token", ["container" => 'col-span-7 hidden', 'required' => false]);
        $this->addField('role' , ["container" => 'col-span-7 ', 'required' => false]);

        return $this->fields;
    }

    public function columns()
    {

        $this->addColumn("name");
        $this->addColumn("username");
        $this->addColumn("branch");
        // $this->addColumn("role");

        return $this->columns;
    }
}
