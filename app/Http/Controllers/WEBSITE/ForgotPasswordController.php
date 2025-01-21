<?php

namespace App\Http\Controllers\WEBSITE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    public function render()
    {
        return view('website.pages.auth.forgot-password');
    }


    public function showResetForm()
    {
        
        return view('website.pages.auth.password-reset');
    }
    
}
