<?php

namespace App\Http\Controllers\WEBSITE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OtpVerificationController extends Controller
{
    public function render(Request $request)
    {
        $cinemaPrefix = $request->route('cinema_prefix');
        $langPrefix = $request->route('language_prefix');
  
        return view('website.pages.auth.otp-verification', compact('cinemaPrefix', 'langPrefix'));
    }
}
