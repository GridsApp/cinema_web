<?php

namespace App\Entities;

use Illuminate\Support\Facades\Route;
use twa\cmsv2\Entities\Entity;

class BranchesEntity extends Entity
{

    public $entity = "Branches";
    public $tableName = "branches";
    public $slug = "branches";



    public $conditions = [
        [
                'type' => 'where',
                'column' => 'branches.id',
                'operand' => null,
                'value' => '{branch_id}'
        ]
    ];


    public $params = [
        'pagination' => 20,
    ];
    public function setRowOperations()
    {


        $route = "/".Route::getRoutes()->getByName('branch-items')->uri();
        $this->setRowOperation("View Items" , $route , '<i class="fa-solid fa-eye"></i>');

        $edit_route = "/".Route::getRoutes()->getByName('entity.update')->uri();
        $this->setRowOperation("Edit" ,  str_replace('{slug}' , $this->slug , $edit_route),  '<i class="fa-solid fa-edit"></i>');
  
    }


    public function fields(){

        $this->addField("label" , ["container" => 'col-span-6', 'required' => true,'translatable'=>true]);
        $this->addField("web_prefix" , ["container" => 'col-span-6', 'required' => true]);
        $this->addField("image" , ["container" => 'col-span-12', 'required' => true]);
        $this->addField("description" , ["container" => 'col-span-12','translatable'=>true]);
        $this->addField("latitude" , ["container" => 'col-span-6', 'required' => true]);
        $this->addField("longitude" , ["container" => 'col-span-6', 'required' => true]);
        $this->addField("address" , ["container" => 'col-span-6', 'required' => true,'translatable'=>true]);
        $this->addField("number" , ["container" => 'col-span-6', 'required' => true]);
        $this->addField("email" , ["container" => 'col-span-6']);

        $this->addField("display" , ["container" => 'col-span-6']);
     


        return $this->fields;
    }

    public function columns(){
        $this->addColumn("label",['translatable'=>true] );
        $this->addColumn("image" );
        $this->addColumn("description",['translatable'=>true]);
        $this->addColumn("latitude" );
        $this->addColumn("longitude" );
        $this->addColumn("address" ,['translatable'=>true]);
        $this->addColumn("number" );
        return $this->columns;
    }


    public function filters(){
     
        // $this->addFilter("display");

        return $this->filters;
    }



}
