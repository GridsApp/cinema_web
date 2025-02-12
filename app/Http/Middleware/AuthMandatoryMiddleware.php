<?php

namespace App\Http\Middleware;

use App\Interfaces\TokenRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\PosUserRepositoryInterface;

use twa\cmsv2\Traits\APITrait;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthMandatoryMiddleware
{
    use APITrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

     private TokenRepositoryInterface $tokenRepository;
     private UserRepositoryInterface $userRepository;
     private PosUserRepositoryInterface $posUserRepository;
 
 
     public function __construct(
         TokenRepositoryInterface $tokenRepository, 
         UserRepositoryInterface $userRepository,
         PosUserRepositoryInterface $posUserRepository
         )
     {
         $this->tokenRepository = $tokenRepository;
         $this->userRepository = $userRepository;
         $this->posUserRepository = $posUserRepository;
     }

    public function handle(Request $request, Closure $next): Response
    {

        $access_token = get_header_access_token();

  
        if (!$access_token) {
            return $this->response(notification()->error("Access Token is required", "Access Token is required"));
        }

        $access_token = $this->tokenRepository->getActiveAccessToken($access_token);

        if (!$access_token) {
            return $this->response(notification()->error("Access Token has expired or is invalid", "Access Token has expired or is invalid"));
        }


        try {
            switch($access_token->type){
                case "USER" : 
                    $user = $this->userRepository->getUserById($access_token->user_id);
                    request()->merge([
                        'user_type' => 'USER',
                        'user' => $user,
                        'system_id' => 1
                    ]);
                    break;
                case "POS" :
                    $user = $this->posUserRepository->getUserById($access_token->user_id);
                    request()->merge([
                        'user_type' => 'POS',
                        'user' => $user,
                        'system_id' => 2
                    ]);
                    break;
    
            }
        } catch (\Throwable $th) {
           
            return $this->response(notification()->error("Not found", "Not found"));
        }
      


        return $next($request);
    }
}
