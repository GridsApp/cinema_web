<?php

namespace App\Entities;

use twa\cmsv2\Entities\Entity;

class AccessTokensEntity extends Entity
{

    public $entity = "Access Tokens Entity";
    public $tableName = "access_tokens";
    public $slug = "access-tokens";


    public $params = [
        'pagination' => 20,
    ];

    public function fields()
    {
    
        $this->addField("token", ["container" => 'col-span-7']);
        $this->addField("type", ["container" => 'col-span-7']);
        $this->addField("user_id", ["container" => 'col-span-7']);
        $this->addField("expires_at", ["container" => 'col-span-7']);
        $this->addField("ip", ["container" => 'col-span-7']);



        return $this->fields;
    }

    public function columns()
    {
        $this->addColumn("token", ['translatable' => true]);

        return $this->columns;
    }
}
