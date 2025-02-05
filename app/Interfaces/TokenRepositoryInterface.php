<?php

namespace App\Interfaces;

interface TokenRepositoryInterface 
{
    public function countPreviousVerifyTokens($user_id);
    public function getActiveAccessToken($access_token);
    public function createVerifyToken($user, $driver , $action);
    public function getActiveVerifyToken($user_id);
    public function createAccessToken($user);
    public function getVerifyToken($token);
    public function createUserToken();

  

 
}