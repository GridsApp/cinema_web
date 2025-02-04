<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Interfaces\TokenRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\CardRepositoryInterface;
use twa\cmsv2\Traits\APITrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{

    use APITrait;

    private TokenRepositoryInterface $tokenRepository;
    private UserRepositoryInterface $userRepository;
    private CardRepositoryInterface $cardRepository;

    public function __construct(TokenRepositoryInterface $tokenRepository, UserRepositoryInterface $userRepository, CardRepositoryInterface $cardRepository)
    {
        $this->tokenRepository = $tokenRepository;
        $this->userRepository = $userRepository;
        $this->cardRepository = $cardRepository;
    }

    public function getAccount()
    {

        $user = request()->user;

        $active_card = $this->cardRepository->getActiveCard($user);

        $account =
            [

                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'profile_picture' => get_image($user->profile_picture),
                'dob' => $user->dob,
                'dom' => $user->dom,
                'login_provider' => $user->login_provider,
                'gender' => $user->gender,
                'card' => $active_card,
            ];


        return $this->responseData($account);
    }

    public function completeProfile()
    {
        $form_data = clean_request();
        $validator = Validator::make($form_data, [
            'user_id' => ['required'],

        ]);
        if ($validator->errors()->count() > 0) {
            return  $this->responseValidation($validator);
        }

        try {
            $user = $this->userRepository->getUserById($form_data['user_id']);
        } catch (\Throwable $th) {
            return $this->response(notification()->error("User not found", "User not found"));
        }


        $updateData = [];


        if (isset($form_data['name'])) {
            $updateData['name'] = $form_data['name'];
        }
        if (isset($form_data['email'])) {
            $updateData['email'] = $form_data['email'];
        }
        if (isset($form_data['phone'])) {
            $updateData['phone'] = $form_data['phone'];
        }
        if (isset($form_data['password'])) {
            $updateData['password'] = $form_data['password'];
        }
        if (isset($form_data['gender'])) {
            $updateData['gender'] = $form_data['gender'];
        }

        if (isset($form_data['dom'])) {
            $updateData['dom'] = $form_data['dom'];
        }

        if (isset($form_data['dob'])) {
            $updateData['dob'] = $form_data['dob'];
        }

        User::whereNull('deleted_at')->where('id', $form_data['user_id'])
            ->update($updateData);

        return $this->response(notification()->success("User updated successfully!", "User updated successfully"));
    }

    public function changePassword()
    {
        $form_data = request()->all();
        $validator = Validator::make($form_data, [
            'current_password' => 'required',
            'password' => [
                'required',
                'min:8',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*?&]/',
            ],
            'confirm_password' => 'required|same:password'
        ]);

        if ($validator->fails()) {
            return  $this->responseValidation($validator);
        }

        $user = request()->user;

        if (Hash::check($form_data['password'], $user->password)) {
            return $this->response(notification()->error('Error', 'You have entered an already existing password'), 403);
        }

        if (!Hash::check($form_data['current_password'], $user->password)) {
            return $this->response(notification()->error('Error', 'Current password is incorrect'), 403);
        }

        $this->userRepository->changePassword($user, $form_data['password']);

        return $this->response(notification()->success('Password succesfully changed', 'Password succesfully changed'));
    }

    public function deleteAccount()
    {

        $user = request()->user;

        $this->userRepository->deleteAccount($user);

        return $this->response(notification()->success('Account deleted', 'Account has been successfully deleted'));
    }
}
