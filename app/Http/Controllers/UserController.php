<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function render()
    {

        return view('pages.get-user');
    }

    public function renderUncompletedPayments()
    {
        return view('pages.uncompleted-payments');
    }


    public function recover($id)
    {


        $user = User::findOrFail($id);

        if ($user->deleted_at) {
            $user->deleted_at = null;
            $user->save();
            return redirect()->back()->with('success', 'User has been recovered.');
        }

        return redirect()->back()->with('info', 'User is not deleted.');
    }

    public function renderPaymentLookup()
    {
        return view('pages.payment-lookup');
    }
}
