<?php

namespace App\Entities;

use twa\cmsv2\Entities\Entity;

class RewardsEntity extends Entity
{

    public $entity = "Rewards";
    public $tableName = "rewards";
    public $slug = "rewards";


    public $params = [
        'pagination' => 20,
    ];

    public function fields()
    {

        $this->addField("title", ["container" => 'col-span-6', 'required' => true]);
        $this->addField("redeem_points", ["container" => 'col-span-6', 'required' => true]);

        $this->addField("image", ["container" => 'col-span-12']);
        $this->addField("description", ["container" => 'col-span-12', 'required' => true]);

        $this->addField("one_time_usage", ["container" => 'col-span-12', 'required' => true]);

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
