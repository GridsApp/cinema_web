<?php

namespace App\Entities;


class UserVerifyTokensEntity extends Entity
{

    public $entity = "User Verify Tokens Entity";
    public $tableName = "user_verify_tokens";
    public $slug = "user-verify-tokens";


    public $params = [
        'pagination' => 20,
    ];

    public function fields()
    {  

        $this->addField("token", ["container" => 'col-span-7']);
        $this->addField("otp", ["container" => 'col-span-7']);
        $this->addField("driver", ["container" => 'col-span-7']);
        $this->addField("user_id", ["container" => 'col-span-7']);
        $this->addField("expires_at", ["container" => 'col-span-7']);
        $this->addField("sent", ["container" => 'col-span-7']);
        $this->addField("ip", ["container" => 'col-span-7']);


        return $this->fields;
    }

    public function columns()
    {
        $this->addColumn("token",['translatable'=>true]);

        return $this->columns;
    }
}
