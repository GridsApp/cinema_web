<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\SurveyResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SurveyController extends Controller
{
   

    public function showSurvey($order_id, $user_id, $token)
    {
       
        if ($token !== md5($order_id . $user_id)) {
            abort(404);
        }

       
        $purchase = Order::find($order_id);
        if (!$purchase) {
            abort(404);
        }

       
        $cinema = DB::table('branches')->where('id', $purchase->branch_id)->first();
        if (!$cinema) {
            abort(404);
        }

       
        $title = [
            "en" => "Thank you for visiting " . $cinema->label_en,
            "ar" => "شكراً لزيارتكم " . $cinema->label_ar
        ];

        return view('pages.survey', compact('title', 'purchase', 'cinema'));
    }
    
    public function submitSurvey(Request $request)
    {
        
        $validatedData = $request->validate([
            'order_id' => 'required',
            'user_id' => 'required',
            'rating_movie' => 'required',
            'rating_popcorn_pepsi' => 'required',
            'rating_other_items' => 'required',
            'rating_ticketing_service' => 'required',
            'rating_cafeteria_service' => 'required',
            'rating_users_service' => 'required',
            'rating_ticketing_friendliness' => 'required',
            'rating_cafeteria_friendliness' => 'required',
            'rating_users_friendliness' => 'required',
            'rating_ticketing_cleanliness' => 'required',
            'rating_cafeteria_cleanliness' => 'required',
            'rating_users_cleanliness' => 'required',
            'rating_app' => 'required',
            'message' => 'nullable',
        ]);

        SurveyResult::create($validatedData);



        $purchase = Order::find(request()->input("order_id"));
        if($purchase){
            $purchase->survey_submitted = 1;
            $purchase->save();
        }


        return redirect()->back()->with('success', 'Thank you for your feedback!');
    }


   
}
