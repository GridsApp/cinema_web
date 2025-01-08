<?php

namespace App\Entities;

use twa\cmsv2\Entities\Entity;
class CompanyPurposesEntity extends Entity
{

    public $entity = "Company Purposes";
    public $tableName = "company_purposes";
    public $slug = "company-purposes";


    public $params = [
        'pagination' => 20,
    ];

    public function fields(){

        $this->addField("content" , ["container" => 'col-span-12']);
      
        return $this->fields;
    }

    public function columns(){
        $this->addColumn("content");  
        return $this->columns;
    }


}
