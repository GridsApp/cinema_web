<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\MovieShow;
use App\Models\MovieShowCreationLog;
use App\Models\Theater;
use App\Rules\TimeConflictRule;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MovieShowsLogsController extends Controller
{

    public function render()
    {
        return view('pages.movie-show-logs');
    }



   


  
  
}
