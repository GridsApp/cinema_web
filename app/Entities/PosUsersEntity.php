<?php

namespace App\Entities;


class PosUsersEntity extends Entity
{

    public $entity = "POS Users";
    public $tableName = "pos_users";
    public $slug = "pos-users";

    public $params = [
        'pagination' => 20,
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
        $this->addColumn("role");

        return $this->columns;
    }
}
