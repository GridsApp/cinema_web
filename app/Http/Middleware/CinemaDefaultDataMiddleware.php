<?php

namespace App\Http\Middleware;

use App\GeneratedModels\CinemasModel;
use App\Models\Branch;
use Closure;
use Illuminate\Http\Request;

class CinemaDefaultDataMiddleware
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


        $branch = Branch::whereNull('deleted_at')
            ->where('web_prefix',$request->segment(1))
            ->first();
        if(!$branch){
            abort(404);
        }
        $request->merge(['branch'=>$branch]);

        return $next($request);
    }
}
