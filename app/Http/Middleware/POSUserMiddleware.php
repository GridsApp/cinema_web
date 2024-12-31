<?php

namespace App\Http\Middleware;



use twa\cmsv2\Traits\APITrait;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class POSUserMiddleware
{
    use APITrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

 
    public function handle(Request $request, Closure $next): Response
    {

        if(request()->input("user_type") == "POS"){
            return $next($request);
        }

        return $this->response(notification()->error("This API works only for POS users", "This API works only for POS users"));
        
    }
}
