<?php

namespace App\Entities;

use twa\cmsv2\Entities\Entity;

class CmsSentPushNotificationsEntity extends Entity
{

    public $entity = "Cms Sent Push Notifications";
    public $tableName = "cms_sent_push_notifications";
    public $slug = "cms-sent-push-notifications";

    public $params = [
        'pagination' => 20,
    ];

    public function fields()
    {

        $this->addField("title", ["container" => 'col-span-6', 'required' => true, 'translatable' => true]);
        $this->addField("message", ["container" => 'col-span-6', 'required' => true, 'translatable' => true]);
        $this->addField("image", ["container" => 'col-span-12']);
        $this->addField("text", ["container" => 'col-span-6', 'required' => true, 'translatable' => true]);

        $this->addField("userable_id", ["container" => 'col-span-7']);
        $this->addField("userable_model", ["container" => 'col-span-7']);



        return $this->fields;
    }

    public function columns()
    {
       
        $this->addColumn("image");

        return $this->columns;
    }


    public function filters()
    {



        return $this->filters;
    }
}
