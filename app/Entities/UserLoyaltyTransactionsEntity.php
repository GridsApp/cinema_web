<?php

namespace App\Entities;

use twa\cmsv2\Entities\Entity;
class UserLoyaltyTransactionsEntity extends Entity
{

    public $entity = "User Loyalty Transactions";
    public $tableName = "user_loyalty_transactions";
    public $slug = "user-loyalty-transactions";


    public $params = [
        'pagination' => 20,
    ];

    public function fields()
    {
        $this->addField("user_id", ["container" => 'col-span-7']);
        $this->addField("user_card_id", ["container" => 'col-span-7']);
        $this->addField("amount", ["container" => 'col-span-7']);
        $this->addField("description", ["container" => 'col-span-7']);
        $this->addField("type", ["container" => 'col-span-7']);
        $this->addField("balance", ["container" => 'col-span-7']);
        $this->addField("reference", ["container" => 'col-span-7']);
        $this->addField("long_id", ["container" => 'col-span-7']);



        return $this->fields;
    }

    public function columns()
    {
    
        return $this->columns;
    }
}
