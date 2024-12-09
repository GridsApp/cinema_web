<?php

namespace App\Entities\FieldTypes;


class Hidden extends FieldType
{

    public function component()
    {
        return "elements.hidden";
    }

}
