<?php

namespace App\Interfaces;

interface ResetPasswordTokenRepositoryInterface 
{
    public function create($user_id);
    public function check($reset_token);
}