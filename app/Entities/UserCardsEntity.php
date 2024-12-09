<?php

namespace App\Entities;


class UserCardsEntity extends Entity
{

    public $entity = "User Cards";
    public $tableName = "user_cards";
    public $slug = "user-cards";


    public $params = [
        'pagination' => 20,
    ];

    public function fields()
    {
    
       
        $this->addField("user_id", ["container" => 'col-span-7']);
        $this->addField("barcode", ["container" => 'col-span-7']);
        $this->addField("type", ["container" => 'col-span-7']);
        $this->addField("disabled_at", ["container" => 'col-span-7']);



        return $this->fields;
    }

    public function columns()
    {

        return $this->columns;
    }
}
