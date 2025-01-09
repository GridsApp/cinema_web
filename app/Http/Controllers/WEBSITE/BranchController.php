<?php

namespace App\Http\Controllers\WEBSITE;

use App\Http\Controllers\Controller;
use App\Interfaces\BranchRepositoryInterface;
use Illuminate\Http\Request;

class BranchController extends Controller
{


   private BranchRepositoryInterface $branchRepository;

   public function __construct()
   {

      $this->branchRepository = app(BranchRepositoryInterface::class);
   }

   public function listing()
   {
      $branches = $this->branchRepository->getBranches();

      return view('website.pages.branch.listing', [
         'branches' => $branches,
      ]);
   }
}
