<?php

namespace App\Interfaces;

interface PosUserRepositoryInterface
{

    public function getUserByUsername($username , $branch_id);
    public function getUserById($id);
    public function getManagers($branch_id);
    public function getManagerByIdAndPin($id , $pincode,$branch_id);
    
}
