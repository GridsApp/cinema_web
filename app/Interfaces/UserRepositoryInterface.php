<?php

namespace App\Interfaces;

interface UserRepositoryInterface
{
    public function createCustomer($phone_number, $password, $full_name, $email, $gender = null , $dom = null , $dob = null) ;
    public function createUser($phone_number, $password = null);
    public function changePassword($user, $password);
    public function getUserByPhone($phone_number);
    public function getUserByEmail($email);
    public function getUserByCardNumber($card_number);
    // public function getPosUserByUsername($username);
    public function getUserByToken($token);
    public function getUserById($user_id);
    public function deleteAccount($user);
   
  
}
