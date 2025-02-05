<?php

namespace App\Entities;

use twa\cmsv2\Entities\Entity;
class ResetPasswordTokensEntity extends Entity
{

    public $entity = "Reset Password Tokens Entity";
    public $tableName = "reset_password_tokens";
    public $slug = "reset-password-tokens";


    public $params = [
        'pagination' => 20,
    ];

    public function fields()
    {  

        $this->addField("token", ["container" => 'col-span-7']);
        $this->addField("user_id", ["container" => 'col-span-7']);
        $this->addField("expires_at", ["container" => 'col-span-7']);
     
        return $this->fields;
    }

    public function columns()
    {
        $this->addColumn("token",['translatable'=>true]);

        return $this->columns;
    }
}
