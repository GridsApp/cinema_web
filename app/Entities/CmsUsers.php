<?php

namespace App\Entities;

use twa\cmsv2\Entities\CmsUsers as BaseCmsUsers;

class CmsUsers extends BaseCmsUsers
{

    public function attributes(){
        $this->addAttribute("branch_attribute");

        return $this->attributes;
    }


}
