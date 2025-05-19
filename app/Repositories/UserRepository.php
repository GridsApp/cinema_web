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


        // if ($password) {
        //     $user->password = Hash::make($password);
        // }

        if ($password) {
            $user->password = md5($password);
        }
        $user->save();

        return $user;
    }


    public function createVerifiedUser($phone_number, $password = null)
    {
        $user = new User;
        $user->phone = $phone_number;
        $user->token = $this->tokenRepository->createUserToken();
        $user->phone_verified_at = now();

        // if ($password) {
        //     $user->password = Hash::make($password);
        // }

        if ($password) {
            $user->password = md5($password);
        }
        $user->save();

        return $user;
    }







    public function createCustomer($phone_number, $password, $full_name, $email, $gender = null, $dom = null, $dob = null)
    {
        $user = new User;
        $user->phone = $phone_number;
        $user->name = $full_name;
        $user->email = $email;
        $user->email_verified_at = $email ? now() : null;
        $user->phone_verified_at = $phone_number ? now() : null;
        $user->gender = $gender;
        $user->dob = $dob;
        $user->dom = $dom;
        $user->token = $this->tokenRepository->createUserToken();

        if ($password) {
            $user->password = md5($password);
        }

        $user->save();
        return $user;
    }


    public function getUserByPhone($phone_number, $includeDeleted = false)
    {
        try {
            $query = User::where('phone', $phone_number);
    
            if (!$includeDeleted) {
                $query->whereNull('deleted_at');
            }
    
            return $query->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new Exception($e->getMessage());
        }
    }
    


    public function getVerifiedUserByPhone($phone_number)
    {

        $user = User::where('phone', $phone_number)
            ->whereNull('deleted_at')
            ->whereNotNull('phone_verified_at')
            ->first();

        return $user;
    }


    public function getUserByCardNumber($card_number,$includeDeleted=false)
    {


        try {
            $user_card = UserCard::where('barcode', $card_number)

            
                ->whereNull('deleted_at')->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e->getMessage());
        }

        try {
            $user = User::where('id', $user_card->user_id);

            if (!$includeDeleted) {
                $user->whereNull('deleted_at');
            }
                // ->whereNull('deleted_at')
                $user= $user->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e->getMessage());
        }

        return $user;
    }


    // public function getUserByEmail($email)
    // {
    //     try {
    //         return User::whereNull('deleted_at')
    //             ->where('email', $email)

    //             ->firstOrFail();
    //     } catch (ModelNotFoundException $e) {
    //         throw new ModelNotFoundException($e->getMessage());
    //     }
    // }
    public function getUserByEmail($email, $includeDeleted = false)
    {
        try {
            $query = User::query();

            if (!$includeDeleted) {
                $query->whereNull('deleted_at');
            }

            return $query->where('email', $email)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e->getMessage());
        }
    }


    public function getVerifiedUserByEmail($email)
    {
        try {
            return User::whereNull('deleted_at')
                ->where('email', $email)
                ->whereNotNull('email_verified_at')
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
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e->getMessage());
        }
    }
    
    public function getUserById($user_id, $includeDeleted = false)
    {
        try {
            $query = User::where('id', $user_id);
    
            if (!$includeDeleted) {
                $query->whereNull('deleted_at');
            }
    
            return $query->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException("User with ID {$user_id} not found.");
        }
    }
    

    public function changePassword($user, $password)
    {
        $user->password = md5($password);
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
            $access_token->expires_at = now();
            $access_token->save();
        }

        return true;
    }
}
