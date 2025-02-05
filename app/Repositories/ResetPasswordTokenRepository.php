<?php

namespace App\Repositories;

use App\Interfaces\ResetPasswordTokenRepositoryInterface;
use App\Models\ResetPasswordToken;


class ResetPasswordTokenRepository implements ResetPasswordTokenRepositoryInterface
{


    public function create($user_id)
    {
        $reset_password = new ResetPasswordToken();
        $reset_password->user_id = $user_id;
        $reset_password->token = generate_unique_token();
        $reset_password->expires_at = now()->addMinutes(5);
        $reset_password->save();

        return $reset_password;
    }
    public function check($reset_token)
    {
       
      $reset_token=  ResetPasswordToken::whereNull('deleted_at')
            ->where('token', $reset_token)
            ->where('expires_at', '>', now())
            ->first();

            return $reset_token;
    }
}
