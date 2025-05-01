<?php

namespace App\Http\Controllers\WEBSITE;

use App\Http\Controllers\Controller;
use App\Models\InformativePages;
use Illuminate\Http\Request;

class PrivacyPolicyController extends Controller
{
    public function render(){


       $page = InformativePages::where('slug' , 'privacy-policy')->whereNull('deleted_at')->firstOrFail();


       

        return view('website.pages.privacy-policy' , compact('page'));

    }
}
