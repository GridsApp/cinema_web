<?php

namespace App\Repositories;

use App\Interfaces\TokenRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Models\PosUser;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\UserCard;
use Exception;
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
    public function createCustomer($phone_number, $password, $full_name, $email , $gender = null , $dom = null , $dob = null)
    {
        $user = new User;
        $user->phone = $phone_number;
        $user->name = $full_name;
        $user->email = $email;
        $user->gender = $gender;
        $user->dob = $dob;
        $user->dom = $dom;
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
                throw new Exception($e->getMessage());
            }
            return $user;
    }


    public function getUserByCardNumber($card_number){


        try {
            $user_card = UserCard::where('barcode', $card_number)
               ->whereNull('deleted_at')->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e->getMessage());
        }

        try {
            $user = User::where('id', $user_card->user_id)
               ->whereNull('deleted_at')->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e->getMessage());
        }

        return $user;


    }


    public function getUserByEmail($email)
    {
        try {
            return User::whereNull('deleted_at')
                ->where('email', $email)
                ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e->getMessage());
        }
    }

    public function getUserByToken($token)
    {
        try {
        return User::whereNull('deleted_at')
            ->where('token', $token)
            ->firstOrFail();
        }
            catch (ModelNotFoundException $e) {
                throw new ModelNotFoundException($e->getMessage());
            }
    }

    public function getUserById($user_id)
    {

        try {
            $user = User::where('id', $user_id)
               ->whereNull('deleted_at')->firstOrFail();
            //    dd($user);
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException("User with ID {$user_id} not found.");
        }

        return $user;
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
