<?php

namespace App\Reports;



class Report
{

    public $columns = [];
    public $rows = [];
    public $footer = [];

    public function __construct()
    {
        $this->columns = collect([]);

        $this->header();
        $this->footer();

    }

    public function setRow($data){
        $row = [];

        foreach($this->columns as $column){
            $row[$column['name']] = $data[$column['name']] ?? "";
        }


        return $row;
    }
    public function addColumn($name , $label){
        // $this->columns->push([
        //     'name' => $name,
        //     'label' => $label
        // ]);
    }

    public function setFooter($column , $value){
        
        $footer = []; 

        foreach($this->columns as $column){
            if($column['name'] == $column){
                $footer[$column['name']] = $value;
            }else{
                $footer[$column['name']] = $footer[$column['name']] ?? "-";
            }
        }
        
    }



    public function header(){

    }

    public function rows(){


    }

    public function footer(){

    }



}
