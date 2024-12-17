<?php

namespace App\Entities;
use twa\cmsv2\Entities\Entity;

class UserRewardsEntity extends Entity
{

    public $entity = "User Rewards";
    public $tableName = "user_rewards";
    public $slug = "user-rewards";


    public $params = [
        'pagination' => 20,
    ];

    public function fields()
    {

        $this->addField("user_id", ["container" => 'col-span-6', 'required' => true]);
        $this->addField("reward_id", ["container" => 'col-span-6', 'required' => true]);
        $this->addField("code", ["container" => 'col-span-12']);
        $this->addField("used_at", ["container" => 'col-span-12', 'required' => false]);
       
    
        return $this->fields;
    }

    public function columns()
    {
        $this->addColumn("image", ["container" => 'col-span-12']);
        $this->addColumn("title", ["container" => 'col-span-6', 'required' => true]);
        $this->addColumn("redeem_points", ["container" => 'col-span-6', 'required' => true]);

      
        return $this->columns;
    }
}
