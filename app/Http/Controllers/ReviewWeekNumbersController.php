<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReviewWeekNumbersController extends Controller
{

    public function render(){
        return view('pages.review-week-numbers');
    }
}
