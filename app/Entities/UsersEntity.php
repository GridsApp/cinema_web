<?php

namespace App\Entities;

use twa\cmsv2\Entities\Entity;
class UsersEntity extends Entity
{

    public $entity = "Users";
    public $tableName = "users";
    public $slug = "users";


    // public $form = "pages.form.movie";


    public $params = [
        'pagination' => 20,
    
    ];

    public function fields()
    {

        $this->addField("name", ["container" => 'col-span-7']);
        $this->addField("email", ["container" => 'col-span-4', 'required' => true]);
        $this->addField("email_verified", ["container" => 'col-span-3']);

        $this->addField("phone", ["container" => 'col-span-4', 'required' => true]);
        $this->addField("phone_verified", ["container" => 'col-span-3']);

        $this->addField("profile_picture", ["container" => 'col-span-7']);
        $this->addField("password", ["container" => 'col-span-7', 'required' => true]);
        $this->addField("gender", ["container" => 'col-span-7']);
        $this->addField("date_birth", ["container" => 'col-span-7']);
        // $this->addField("marital_status", ["container" => 'col-span-7']);
        $this->addField("date_marriage", ["container" => 'col-span-7']);


        $this->addField("token", ["container" => 'col-span-7', 'required' => true]);


        $this->addField("login_provider", ["container" => 'col-span-7', 'required' => true]);

        return $this->fields;
    }

    public function columns()
    {
        $this->addColumn("name");
        $this->addColumn("email");


        return $this->columns;
    }
}
