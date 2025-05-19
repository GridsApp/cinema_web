<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GroupMoviesController extends Controller
{
    public function groupMovies(){
        

        return view('pages.group-movies');
    }
}
