<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function render(){

        return view('pages.get-user');

    }

    public function renderUncompletedPayments(){
        return view('pages.uncompleted-payments');
    }

}
