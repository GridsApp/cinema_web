<?php

namespace App\Entities\FieldTypes;

use twa\cmsv2\Entities\FieldTypes\FieldType;


class PriceSettings extends FieldType
{

    public function component()
    {
        return "components.price-settings";
    }


    public function db(&$table){
        $table->longText($this->field['name'])->nullable();
    }

    public function initalValue($data)
    {


        if(!isset($data->{$this->field['name']}) || (isset($data->{$this->field['name']}) && !$data->{$this->field['name']})){
            return [
                "defaultPrice" => "",
                "conditions" => [],
                'moviePrices' => [],
                'moviePriceConditions' => []
            ];
        }

        $decoded =  json_decode($data->{$this->field['name']} ?? '
                    {
                      "defaultPrice" : "",
                      "conditions" : [],
                      "moviePrices" : [],
                      "moviePriceConditions" : []
                    }
        ');


        return json_decode(json_encode([
            "defaultPrice" => $decoded->defaultPrice ?? "",
            "conditions" => $decoded->conditions ?? [],
            'moviePrices' => $decoded->moviePrices ?? [],
            'moviePriceConditions' => $decoded->moviePriceConditions ?? []
        ]));

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
