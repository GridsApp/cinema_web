<?php

namespace App\Interfaces;

interface KioskUserRepositoryInterface
{

    public function getUserByUsername($username);
    public function getUserById($id);
    public function getManagers($branch_id);
    public function getManagerByIdAndPin($id , $pincode,$branch_id);
    
}
