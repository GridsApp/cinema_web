<?php

namespace App\Entities;

use twa\cmsv2\Entities\Entity;

class SurveyResultsEntity extends Entity
{

    public $entity = "Survey Results";
    public $tableName = "survey_results";
    public $slug = "survey-results";

    public $params = [
        'pagination' => 20,
    ];


    public function fields()
    {

        $this->addField("order_id", ["container" => 'col-span-6']);
        $this->addField("user_id", ["container" => 'col-span-6']);
        $this->addField("rating_movie", ["container" => 'col-span-12']);
        $this->addField("rating_popcorn_pepsi", ["container" => 'col-span-12']);
        $this->addField("rating_other_items", ["container" => 'col-span-12']);
        $this->addField("rating_ticketing_service", ["container" => 'col-span-12']);

        $this->addField("rating_cafeteria_service", ["container" => 'col-span-12']);
        $this->addField("rating_users_service", ["container" => 'col-span-12']);
        $this->addField("rating_ticketing_friendliness", ["container" => 'col-span-12']);
        $this->addField("rating_cafeteria_friendliness", ["container" => 'col-span-12']);

        $this->addField("rating_users_friendliness", ["container" => 'col-span-12']);
        $this->addField("rating_ticketing_cleanliness", ["container" => 'col-span-12']);
        $this->addField("rating_cafeteria_cleanliness", ["container" => 'col-span-12']);

        $this->addField("rating_users_cleanliness", ["container" => 'col-span-12']);
        $this->addField("rating_app", ["container" => 'col-span-12']);
        $this->addField("message", ["container" => 'col-span-12']);




        return $this->fields;
    }

    public function columns()
    {
        $this->addColumn("order_id");
        $this->addColumn("user_id");
        $this->addColumn("rating_movie");

        return $this->columns;
    }


    public function filters()
    {



        return $this->filters;
    }
}
