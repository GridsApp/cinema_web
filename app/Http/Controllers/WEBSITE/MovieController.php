<?php

namespace App\Http\Controllers\WEBSITE;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
public function listing(){
   

        // $services = ServicesModel::where('cancelled', 0)->orderBy('orders')->get();
        // $categories = CategoriesModel::where('cancelled', 0)->orderBy('orders')->get();
        $movies = Movie::whereNull('deleted_at')->get();
        $branches=Branch::whereNull('deleted_at')->get();
      
        return view('website.pages.movie.listing', [
            'movies' => $movies,
            'branches' => $branches,
        
        ]);
    
}
}
