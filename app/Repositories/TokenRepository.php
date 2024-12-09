<?php

namespace App\Repositories;

use App\Interfaces\TokenRepositoryInterface;
use App\Models\AccessToken;
use App\Models\UserVerifyToken;

class TokenRepository implements TokenRepositoryInterface
{


    public $expiry_duration = 3;

    public function createVerifyToken($user, $driver)
    {

        UserVerifyToken::where('user_id', $user->id)
            ->where('expires_at', '>', now())
            ->update([
                'expires_at' => now(),
            ]);

        $token = uniqid() . '-' . uniqid();
        $verify_token = new UserVerifyToken;
        $verify_token->otp = rand(1000, 9999);
        $verify_token->token = $token;
        $verify_token->user_id = $user->id;
        $verify_token->ip = request()->ip();
        $verify_token->expires_at = now()->addMinutes($this->expiry_duration);
        $verify_token->driver = $driver;
        $verify_token->save();


        return $verify_token;
    }

    public function getActiveAccessToken($access_token){
        return AccessToken::where('token', $access_token)
        ->where('expires_at', '>', now())
        ->whereNull('deleted_at')
        ->first();
    }

    public function createAccessToken($user , $type = "USER")
    {
        $token = $type."|".$user->id."|".hash('sha256',sprintf(
            '%s%s%s',
            '',
            $tokenEntropy = str()->random(40),
            hash('crc32b', $tokenEntropy)
        ));

        $access_token = new AccessToken;
        $access_token->token = $token;
        $access_token->type = $type;
        $access_token->user_id = $user->id;
        $access_token->ip = request()->ip();
        $access_token->expires_at = now()->addMonths(6);
        $access_token->save();

        return $access_token->token;
    }

    public function getVerifyToken($token)
    {
        return UserVerifyToken::whereNull('deleted_at')
            ->where('token', $token)
            ->first();
    }

    public function createUserToken()
    {
        return md5(uniqid() . env('APP_KEY')) . md5(uniqid() . env('APP_KEY'));
    }


    public function getActiveVerifyToken($user_id){
        return UserVerifyToken::whereNull('deleted_at')
        ->where('user_id' , $user_id)
        ->where('expires_at' , '>' , now())
        ->first();
    }

    public function countPreviousVerifyTokens($user_id , $duration = 30){
        return UserVerifyToken::whereNull('deleted_at')
        ->where('created_at' , '<' , now()->addMinute($duration))
        ->where('user_id' , $user_id)
        ->count();

    }
 
}
