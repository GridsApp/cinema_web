<?php

namespace App\Http\Middleware;

use App\GeneratedModels\AccessTokensModel;
use App\GeneratedModels\UsersModel;
use App\Interfaces\TokenRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Models\AccessToken;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;

class CheckWebsiteAuth
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */


    public function handle(Request $request, Closure $next)
    {

        // $accessToken = session('access_token');

        $user = session('user');

        // dd($user->id);
        if (!$user) {

            return redirect()->route('login-web',[   'cinema_prefix' => request()->route('cinema_prefix'),
            'language_prefix' => request()->route('language_prefix'),]);
        }



        return $next($request);
    }
}
