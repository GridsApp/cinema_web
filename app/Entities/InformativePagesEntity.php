<?php

namespace App\Entities;


use twa\cmsv2\Entities\Entity;

class InformativePagesEntity extends Entity
{

    public $entity = "Informative Pages";
    public $tableName = "informative_pages";
    public $slug = "informative-pages";


    public function fields()
    {

        $channel = "channel".uniqid();
        $languages =config('languages');
        $firstLanguage = $languages[0]['prefix'] ?? '';
     
        $this->addField("label", ["container" => 'col-span-7', 'required' => true,'translatable'=>true , 'channel_type' => 'sender' , 'channel'  => $channel, 'channel_language' => $firstLanguage]); 
        $this->addField("slug", ["container" => 'col-span-7', 'required' => true,'translatable'=>false , 'channel_type' => 'receiver' , 'channel'  => $channel ,'channel_language' => $firstLanguage,]); // sma3e ma3loumet menel label
        $this->addField("content", ["container" => 'col-span-7', 'required' => true,'translatable'=>true]);



        return $this->fields;
    }

    
    public function columns() {

        $this->addColumn('label',['translatable'=>true]);
        return $this->columns;
    }
}
