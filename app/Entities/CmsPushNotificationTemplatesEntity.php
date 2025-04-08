<?php

namespace App\Entities;

use Illuminate\Support\Facades\Route;
use twa\cmsv2\Entities\Entity;

class CmsPushNotificationTemplatesEntity extends Entity
{

    public $entity = "Cms Push Notification Templates";
    public $tableName = "cms_push_notification_templates";
    public $slug = "cms-push-notification-templates";

    public $params = [
        'pagination' => 20,
    ];

    public function fields()
    {

        $this->addField("title", ["container" => 'col-span-6', 'required' => true, 'translatable' => true]);
        $this->addField("message", ["container" => 'col-span-6', 'required' => true, 'translatable' => true]);
        $this->addField("text", ["container" => 'col-span-6', 'required' => true, 'translatable' => true]);
        $this->addField("image", ["container" => 'col-span-12']);



        return $this->fields;
    }

    public function columns()
    {
        // $this->addColumn("title",['translatable'=>true] );

        // $this->addColumn("title" );
        // $this->addColumn('message' ,[], true);
        $this->addColumn("image", [], true);




        return $this->columns;
    }

    public function setRowOperations()
    {


        $route = "/" . Route::getRoutes()->getByName('send-notification')->uri();
  
        $edit_route = "/".Route::getRoutes()->getByName('entity.update')->uri();
        $this->setRowOperation("Edit" ,  str_replace('{slug}' , $this->slug , $edit_route),  '<i class="fa-solid fa-edit"></i>');
  
        $this->setRowOperation("Send", $route, '<i class="fa-solid fa-eye"></i>');
    }

    public function filters()
    {



        return $this->filters;
    }
}
