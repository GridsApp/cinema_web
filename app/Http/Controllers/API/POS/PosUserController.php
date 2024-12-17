<?php

namespace App\Http\Controllers\API\POS;

use App\Http\Controllers\Controller;
use App\Interfaces\PosUserRepositoryInterface;
use App\Interfaces\TokenRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use twa\cmsv2\Traits\APITrait;

use Illuminate\Support\Facades\Validator;


class PosUserController extends Controller
{
    use APITrait;
    private TokenRepositoryInterface $tokenRepository;
    private UserRepositoryInterface $userRepository;
    private PosUserRepositoryInterface $posUserRepository;



    public function __construct(
        TokenRepositoryInterface $tokenRepository,
        UserRepositoryInterface $userRepository,
        PosUserRepositoryInterface $posUserRepository,

    ) {
        $this->tokenRepository = $tokenRepository;
        $this->userRepository = $userRepository;
        $this->posUserRepository = $posUserRepository;
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
            $user = $this->posUserRepository->getUserByUsername($form_data['username']);
        } catch (\Exception $th) {
            return $this->response(notification()->error("You have entered invalid username, password or branch", $th->getMessage()));
        }


        // if (!$user) {
        //     return $this->response(notification()->error("You have entered invalid username/password or branch", 'You have entered invalid username/password or branch'));
        // }

        if ($form_data['passcode'] != $user->passcode) {
            return $this->response(notification()->error("You have entered invalid username/password or branch", 'You have entered invalid username/password or branch'));
        }

        if ($form_data['branch_id'] != $user->branch_id) {
            return $this->response(notification()->error("You have entered invalid username/password or branch", 'You have entered invalid username/password or branch'));
        }

        $access_token = $this->tokenRepository->createAccessToken($user , "POS");
 
        try {
            $managers = $this->posUserRepository->getManagers($form_data['branch_id']);
        } catch (\Exception $th) {
            return $this->response(notification()->error('Error', $th->getMessage()));
        }

        $manager_details = $managers->map(function ($manager) {
            return [
                'id' => $manager->id,
                'name' => $manager->name,
                'pincode' => $manager->pincode,

            ];
        });
        return $this->responseData([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'pincode' => $user->pincode,
                'managers' => $manager_details,
            ],
            'access_token' => $access_token
        ]);
    }
}
