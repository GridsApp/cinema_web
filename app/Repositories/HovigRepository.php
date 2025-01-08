<?php

namespace App\Repositories;


use App\Interfaces\HovigRepositoryInterface;


class HovigRepository implements HovigRepositoryInterface
{

    public function getFirstName()
    {
        return "Hovig";
    }
}
