<?php

namespace App\Entities\FieldTypes;


class Email extends FieldType
{

    public function component()
    {
        return "elements.email";
    }

}
