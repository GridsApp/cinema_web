<?php

namespace App\Http\Controllers\WEBSITE;

use App\Http\Controllers\Controller;
use App\Models\AboutBanner;
use App\Models\AboutParagraph;
use App\Models\BoardMember;
use App\Models\CinemaFounder;
use App\Models\CinemaGrowthPlan;
use App\Models\CompanyPurpose;
use Illuminate\Http\Request;

class AboutController extends Controller
{
   public function about()
   {


      $banner = AboutBanner::whereNull('deleted_at')->where('position','about')->orderBy('id', 'DESC')->first();
      $paragraph = AboutParagraph::whereNull('deleted_at')->orderBy('id', 'DESC')->first();
      $company_purposes = CompanyPurpose::whereNull('deleted_at')->get();
      $cinema_founder = CinemaFounder::whereNull('deleted_at')->orderBy('id', 'DESC')->first();
      $cinema_growth_plans = CinemaGrowthPlan::whereNull('deleted_at')->get();
      $board_members = BoardMember::whereNull('deleted_at')->get();
      // dd($paragraphs);
      return view('website.pages.about-us', [
         'banner' => $banner,
         'paragraph' => $paragraph,
         'company_purposes' => $company_purposes,
         'cinema_founder' => $cinema_founder,
         'cinema_growth_plans' => $cinema_growth_plans,
         'board_members' => $board_members,
      ]);
   }
}
