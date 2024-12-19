<?php

namespace App\Repositories;

use App\Interfaces\TokenRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Models\PosUser;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserRepository implements UserRepositoryInterface
{


    private TokenRepositoryInterface $tokenRepository;


    public function __construct(TokenRepositoryInterface $tokenRepository)
    {
        $this->tokenRepository = $tokenRepository;
    }

    public function createUser($phone_number, $password = null)
    {
        $user = new User;
        $user->phone = $phone_number;
        $user->token = $this->tokenRepository->createUserToken();
        
       
        if ($password) {
            $user->password = Hash::make($password);
        }
        $user->save();

        return $user;
    }
    public function createPosUser($phone_number, $password = null, $full_name, $email, $gender = null, $marital_status = null, $date_birth = null)
    {
        $user = new User;
        $user->phone = $phone_number;
        $user->full_name = $full_name;
        $user->email = $email;
        $user->gender_id = $gender;
        $user->marital_status_id = $marital_status;
        $user->date_birth = $date_birth;
        $user->token = $this->tokenRepository->createUserToken();

        if ($password) {
            $user->password = Hash::make($password);
        }

        $user->save();
        return $user;
    }


    public function getUserByPhone($phone_number)
    {
            try {
                $user = User::where('phone', $phone_number)
                   ->whereNull('deleted_at')->firstOrFail();
            } catch (ModelNotFoundException $e) {
                throw new ModelNotFoundException("User with Phone {$phone_number} not found.");
            }
    
            return $user;
    }
    public function getUserByEmail($email)
    {
        return User::whereNull('deleted_at')
            ->where('email', $email)
            ->first();
    }

    public function getUserByToken($token)
    {
        return User::whereNull('deleted_at')
            ->where('token', $token)
            ->first();
    }

    public function getUserById($user_id)
    {

        try {
            $user = User::where('id', $user_id)
               ->whereNull('deleted_at')->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException("User with ID {$user_id} not found.");
        }

        return $user;
        // return User::whereNull('deleted_at')
        //     ->where('id', $user_id)
        //     ->first();
    }

    public function changePassword($user, $password)
    {
        $user->password = Hash::make($password);
        $user->save();
        return true;
    }

    public function deleteAccount($user)
    {
        $user->deleted_at = now();
        $user->save();

        $token = get_header_access_token();

        $access_token = $this->tokenRepository->getActiveAccessToken($token);
        if ($access_token) {
            $access_token->expired = now();
            $access_token->save();
        }

        return true;
    }
}
