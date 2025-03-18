<?php

namespace App\Entities\FieldTypes;

use twa\cmsv2\Entities\FieldTypes\FieldType;


class CommissionSettings extends FieldType
{

    public function component()
    {
        return "components.commission-settings";
    }


    public function db(&$table){
        $table->longText($this->field['name'])->nullable();
    }

    public function initalValue($data)
    {


        if(!isset($data->{$this->field['name']}) || (isset($data->{$this->field['name']}) && !$data->{$this->field['name']})){
            return [
                "defaultPercentage" => "",
                "conditions" => []
            ];
        }


        $json = $data->{$this->field['name']};

   
        if (is_array($json)) {
            return $json;
        }
    
        return json_decode($data->{$this->field['name']} ?? '
                    {
                      defaultPercentage : "",
                      conditions : []
                    }
        ');
    }

    public function value($form)
    {
        if($form[$this->field['name']] ?? null){
            return json_encode($form[$this->field['name']]);
        }else{
            return "[]";
        }
    }

    public function display($data){
        return null;
    }

}
