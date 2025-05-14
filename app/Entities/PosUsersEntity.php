<?php

namespace App\Entities;

use Illuminate\Support\Facades\Route;
use twa\cmsv2\Entities\Entity;

class PosUsersEntity extends Entity
{

    public $entity = "POS Users";
    public $tableName = "pos_users";
    public $slug = "pos-users";

    public $params = [
        'pagination' => 20,
    ];

    public $row_operations = [];

    public $conditions = [
        [
            'type' => 'where',
            'column' => 'branches.id',
            'operand' => null,
            'value' => '{branch_id}'
        ]
    ];




    public function setRowOperations()
    {
        if (cms_check_permission("edit-" . $this->slug)) {

            $edit_route = "/" . Route::getRoutes()->getByName('entity.update')->uri();

            $this->setRowOperation("Edit",  str_replace('{slug}', $this->slug, $edit_route),  '<i class="fa-solid fa-edit"></i>');
        }



        $route = "/" . Route::getRoutes()->getByName('cashier-shift-summary')->uri();
//        dd($route);

        $this->setRowOperation("Shift Summary",  $route,  '<i class="fa-solid fa-rectangle-list"></i>');



    }

    public function fields()
    {


        $this->addField("name", ["container" => 'col-span-7', 'required' => true]);
        $this->addField("username", ["container" => 'col-span-7', 'required' => true]);
        $this->addField("passcode", ["container" => 'col-span-7', 'required' => false]);
        $this->addField("pincode", ["container" => 'col-span-7', 'required' => true]);
        $this->addField("branch", ["container" => 'col-span-7', 'required' => false]);
        $this->addField("access_token", ["container" => 'col-span-7 hidden', 'required' => false]);
        $this->addField('role' , ["container" => 'col-span-7 ', 'required' => false]);

        return $this->fields;
    }

    public function columns()
    {

        $this->addColumn("name");
        $this->addColumn("username");
        $this->addColumn("branch");
        // $this->addColumn("role");

        return $this->columns;
    }
}
