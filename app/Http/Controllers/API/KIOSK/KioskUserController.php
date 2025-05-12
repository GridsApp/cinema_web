<?php

namespace App\Http\Controllers\API\KIOSK;

use App\Http\Controllers\Controller;
use App\Interfaces\KioskUserRepositoryInterface;
use App\Interfaces\TokenRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use twa\cmsv2\Traits\APITrait;
use Illuminate\Support\Facades\Validator;

class KioskUserController extends Controller
{
    use APITrait;

    private TokenRepositoryInterface $tokenRepository;
    private UserRepositoryInterface $userRepository;
    private KioskUserRepositoryInterface $kioskUserRepository;



    public function __construct(
        TokenRepositoryInterface $tokenRepository,
        UserRepositoryInterface $userRepository,
        KioskUserRepositoryInterface $kioskUserRepository,

    ) {
        $this->tokenRepository = $tokenRepository;
        $this->userRepository = $userRepository;
        $this->kioskUserRepository = $kioskUserRepository;
    }

    public function login()
    {

        $form_data = clean_request([]);

        $validator = Validator::make($form_data, [
            'username' => 'required',
            'passcode' => 'required',
            'branch_id' => 'required'
        ]);

        if ($validator->errors()->count() > 0) {
            return  $this->responseValidation($validator);
        }


        try {
            $user = $this->kioskUserRepository->getUserByUsername($form_data['username']);
        } catch (\Exception $th) {
            return $this->response(notification()->error("You have entered invalid username, password or branch", $th->getMessage()));
        }


        if (md5($form_data['passcode']) != $user->passcode) {
            return $this->response(notification()->error("You have entered invalid username/password or branch", 'You have entered invalid username/password or branch'));
        }

        if ($form_data['branch_id'] != $user->branch_id) {
            return $this->response(notification()->error("You have entered invalid username/password or branch", 'You have entered invalid username/password or branch'));
        }

        $access_token = $this->tokenRepository->createAccessToken($user , "KIOSK");
 
     
        return $this->responseData([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'pincode' => $user->pincode,
                'branch' => [
                  'id'=>$user->branch_id,
                  'label'=>$user->branch->label ?? '',
                ]
            ],
            'access_token' => $access_token
        ]);
    }
}
