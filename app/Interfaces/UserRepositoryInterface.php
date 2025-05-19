<?php

namespace App\Interfaces;

interface UserRepositoryInterface
{
    public function createCustomer($phone_number, $password, $full_name, $email, $gender = null , $dom = null , $dob = null) ;
    public function createUser($phone_number, $password = null);
    public function createVerifiedUser($phone_number, $password = null);
    public function changePassword($user, $password);
    public function getUserByPhone($phone_number, $includeDeleted = false);
    public function getUserByEmail($email, $includeDeleted = false);

    public function getUserByCardNumber($card_number, $includeDeleted = false);
    // public function getPosUserByUsername($username);
    public function getUserByToken($token);
    public function getUserById($user_id, $includeDeleted = false);
    public function deleteAccount($user);

    public function getVerifiedUserByPhone($phone_number);
    public function getVerifiedUserByEmail($email);
   
  
}
