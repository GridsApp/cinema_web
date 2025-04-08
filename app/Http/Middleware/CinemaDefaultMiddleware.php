<?php

namespace App\Http\Middleware;

use App\GeneratedModels\CinemasModel;
use App\Models\Branch;
use Closure;
use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;

class CinemaDefaultMiddleware
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
        $ip=$request->ip();
//        $ip='103.229.80.10';
        $long=0;
        $lat=0;
        $currentUserInfo = Location::get($ip);
        if($currentUserInfo){
            $long=$currentUserInfo->longitude;
            $lat=$currentUserInfo->latitude;
        }

        $haversine = "(
    6371 * acos(
        cos(radians(" .$lat. "))
        * cos(radians(`latitude`))
        * cos(radians(`longitude`) - radians(" .$long. "))
        + sin(radians(" .$lat. ")) * sin(radians(`latitude`))
    )
)";

        $cinemas = Branch::select("*")
            ->selectRaw("$haversine AS distance")
            ->orderby("distance", "asc")
            ->whereNull('deleted_at')
            ->get();

            // dd($cinemas);
     if(isset($cinemas) && count($cinemas)>0){

         if(!isset($cinemas[0]['web_prefix']) || empty($cinemas[0]['web_prefix'])){
             return abort(403, "Please enter web prefix from the CMS for all cinemas");
         }

          if($request->input('notification_title')!=null && $request->input('notification_message')!=null){
             $url= env('APP_URL').'/'.$cinemas[0]['web_prefix'].'/'.app()->getLocale().'?notification_title='.$request->input('notification_title').'&notification_message='.$request->input('notification_message');
              return redirect($url);
          }else{
              return redirect(env('APP_URL').'/'.$cinemas[0]['web_prefix'].'/'.app()->getLocale());
          }

     }else{
         return response()->json(['status' => 'error', 'message' => 'You do not have any cinema defined in your CMS yet.'], 500);

     }

    }
}
