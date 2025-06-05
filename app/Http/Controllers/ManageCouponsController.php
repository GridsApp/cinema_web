<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManageCouponsController extends Controller
{
    public function render()
    {
        return view('pages.manage-coupons');
    }
}
