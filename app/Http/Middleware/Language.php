<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class Language
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

        if($request->segment(2) != app()->getLocale()){

            if(!in_array($request->segment(2) , ['en' , 'ar'])){
                app()->setlocale("en");
            }

            app()->setlocale($request->segment(2));
        }
        URL::defaults([ 'locale' => app()->getLocale() ]);
        return $next($request);
    }
}
