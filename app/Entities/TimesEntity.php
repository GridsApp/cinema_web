<?php

namespace App\Entities;


use Database\Seeders\TimeSeeder;
use twa\cmsv2\Entities\Entity;

class TimesEntity extends Entity
{

    public $entity = "Times";
    public $tableName = "times";
    public $slug = "times";
    public $seeder = TimeSeeder::class;
    public $params = [
        'pagination' => 20
    ];

    public function fields(){

        $this->addField("label" , ["container" => 'col-span-7']);
        $this->addField("iso" , ["container" => 'col-span-7']);


        return $this->fields;
    }

    public function columns(){
        return $this->columns;
    }


}
