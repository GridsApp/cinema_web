<?php

namespace App\Http\Controllers\WEBSITE;

use App\Http\Controllers\Controller;
use App\Models\InformativePages;
use Illuminate\Http\Request;

class PrivacyPolicyController extends Controller
{
    public function render(){

        // dd("here");

       $page = InformativePages::where('slug' , 'privacy-policy')->whereNull('deleted_at')->firstOrFail();


       
    //    dd($page);

        return view('website.pages.privacy-policy' , ['page'=>$page]);

    }
}
