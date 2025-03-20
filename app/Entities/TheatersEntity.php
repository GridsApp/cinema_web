<?php

namespace App\Entities;

use Illuminate\Support\Facades\DB;
use twa\cmsv2\Entities\Entity;

class TheatersEntity extends Entity
{

    public $entity = "Theatres";
    public $tableName = "theaters";
    public $slug = "theaters";


    public $formRender = "admin.forms.theater-maps";

    public $params = [
        'form' => 'admin.forms.theater-maps',
        'pagination' => 20,
        'onsubmit' => [
            [
                'name' => 'label',
                'value' => 'Theater {value}',
                'target' => 'hall_number'
            ]

        ],
    ];



    public $conditions = [
        [
            'type' => 'where',
            'column' => 'branches.id',
            'operand' => null,
            'value' => '{branch_id}'
        ]
    ];


    public function fields()
    {

        $this->addField("label_hidden", ["container" => 'col-span-7']);
        $this->addField("branch", ["container" => 'col-span-7', 'required' => true]);
        $this->addField("hall_number", ["container" => 'col-span-7', 'required' => true]);
        $this->addField("price_groups", ["container" => 'col-span-7', 'required' => true]);
        $this->addField("theater_map_json", ["container" => 'col-span-7', 'required' => true]);
        $this->addField("nb_seats", ["container" => 'col-span-7 hidden']);



        return $this->fields;
    }

    public function columns()
    {


        $this->addColumn("branch");
        $this->addColumn("label_hidden", ['label' => 'Theater']);
        // $this->addColumn("hall_number" );
        $this->addColumn("price_groups");


        return $this->columns;
    }



    public function callback($id)
    {


        $row =  DB::table($this->tableName)->where('id', $id)->first();

        if (!$row) {
            return;
        }

        try {
            $nb_seats = collect(json_decode($row->theater_map))->flatten(1)->where('isSeat', true)->count();
        } catch (\Throwable $th) {
            $nb_seats = 0;
        }

        try {
            DB::table($this->tableName)->where('id', $id)->update([
                'nb_seats' => $nb_seats
            ]);
        } catch (\Throwable $th) {
        }
    }
}
