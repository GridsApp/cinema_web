<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManageCouponsController extends Controller
{
    public function render()
    {
        return view('pages.manage-coupons');
    }

    public function editCoupons($id)
    {
        // dd($id);
        return view('pages.edit-manage-coupons', ['id' => $id]);
    }
}
