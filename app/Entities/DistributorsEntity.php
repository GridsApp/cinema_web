<?php

namespace App\Entities;

use Illuminate\Support\Facades\Route;
use twa\cmsv2\Entities\Entity;

class DistributorsEntity extends Entity
{

    public $entity = "Distributors";
    public $tableName = "distributors";
    public $slug = "distributors";


    public function fields(){
        $this->addField("label" , ["container" => 'col-span-7' , 'required' => true]);
        // $this->addField("main_image" , ["container" => 'col-span-7' , 'required' => true]);
        $this->addField("commission_settings", ["container" => 'col-span-7' ,'required' => true]);
        $this->addField("condensed_label" , ["container" => 'col-span-7' ]);

        


        return $this->fields;
    }


    public function setTableOperations()
    {

        // $route = "/".Route::getRoutes()->getByName('box-office-report')->uri();
        // dd($route);
        // $this->setRowOperation("View Items" , $route , '<i class="fa-solid fa-eye"></i>');

            $this->setTableOperation("Add New Record",  route('entity.create', ['slug' => $this->slug]),  '<i class="fa-solid fa-plus"></i>');
            $this->setTableOperation("Box Office Report",  route('box-office-report.render') ,  '');
            $this->setTableOperation("Box Office Summary",  route('box-office-summary.render'),  '');
            $this->setTableOperation("Distributor Film Hire",  route('distributor-film-hire.render'),  '');
         
     
    }
    public function columns(){

        $this->addColumn("label");
        $this->addColumn("created_at");
        $this->addColumn("updated_at");
        return $this->columns;
    }

}
