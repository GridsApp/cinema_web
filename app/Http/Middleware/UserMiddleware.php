<?php

namespace App\Http\Middleware;



use twa\cmsv2\Traits\APITrait;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    use APITrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

 
    public function handle(Request $request, Closure $next): Response
    {

        $access_token = get_header_access_token();

        if(!$access_token ||($access_token && request()->input("user_type") == "USER")){
            return $next($request);
        }

        return $this->response(notification()->error("This API works only for users", "This API works only for users"));
        
    }
}
