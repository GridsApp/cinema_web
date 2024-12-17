<?php

namespace App\Entities;
use twa\cmsv2\Entities\Entity;

class UserWalletTransactionsEntity extends Entity
{

    public $entity = "User Wallet Transactions";
    public $tableName = "user_wallet_transactions";
    public $slug = "user-wallet-transactions";


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
        $this->addField("gateway_reference", ["container" => 'col-span-7']);


        return $this->fields;
    }

    public function columns()
    {
    
        return $this->columns;
    }
}
