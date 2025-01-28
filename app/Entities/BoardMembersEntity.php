<?php

namespace App\Entities;

use twa\cmsv2\Entities\Entity;
class BoardMembersEntity extends Entity
{

    public $entity = "Board Members";
    public $tableName = "board_members";
    public $slug = "board-members";


    public $params = [
        'pagination' => 20,
    ];

    public function fields(){

        $this->addField("image" , ["container" => 'col-span-12']);
        $this->addField("name" , ["container" => 'col-span-12','translatable'=>true]);
        $this->addField("member_position" , ["container" => 'col-span-12','translatable'=>true]);
        $this->addField("description" , ["container" => 'col-span-12','translatable'=>true]);
      
        return $this->fields;
    }

    public function columns(){
        $this->addColumn("image");  
        return $this->columns;
    }


}
