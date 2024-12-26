<?php

namespace App\Http\Controllers;

use App\Models\Slideshow;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function home()
    {
        $slider= Slideshow::whereNull('deleted_at')->get();
  
        return view('website.home');
    }
}
