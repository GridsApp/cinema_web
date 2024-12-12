<?php

namespace App\Http\Controllers\API;


use App\Interfaces\TokenRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\OTPRepositoryInterface;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Interfaces\CardRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Traits\APITrait;


class AuthController extends Controller
{

    use APITrait;
    private TokenRepositoryInterface $tokenRepository;
    private UserRepositoryInterface $userRepository;
    private OTPRepositoryInterface $otpRepository;
    private CardRepositoryInterface $cardRepository;


    public function __construct(
        TokenRepositoryInterface $tokenRepository,
        UserRepositoryInterface $userRepository,
        OTPRepositoryInterface $otpRepository,
        CardRepositoryInterface $cardRepository
    ) {
        $this->tokenRepository = $tokenRepository;
        $this->userRepository = $userRepository;
        $this->otpRepository = $otpRepository;
        $this->cardRepository = $cardRepository;
    }

    public function register()
    {

        $form_data = clean_request([
            'phone' => 'phone'
        ]);

        $validator = Validator::make($form_data, [
            'phone' => ['required', 'regex:/^\+?[0-9]+$/', 'phone'],
            'password' => 'required',
            'confirm_password' => 'required|same:password'
        ]);

        if ($validator->errors()->count() > 0) {
            return  $this->responseValidation($validator);
        }

        $phone = phone($form_data['phone']);
        $phone_number = $phone->formatE164();



        try {
            $user = $this->userRepository->getUserByPhone($phone_number);
        } catch (\Exception $e) {

            $user = $this->userRepository->createUser($phone_number, $form_data["password"]);

            // return $this->response(notification()->error('Card number not found', $e->getMessage()));
        }


        if ($user && $user->phone_verified) {
            return $this->response(notification()->error('You are already registered user', 'You are already registered user'));
        }


        return $this->responseData([
            'user_token' =>  $user->token,
            'verify_drivers' => $this->otpRepository->getDrivers(),
        ]);
    }

    public function login()
    {


        $form_data = clean_request([
            'phone' => 'phone'
        ]);

        $validator = Validator::make($form_data, [
            'phone' => ['required', 'regex:/^\+?[0-9]+$/', 'phone'],
            'password' => 'required'
        ]);

        if ($validator->errors()->count() > 0) {
            return  $this->responseValidation($validator);
        }

        $phone = phone($form_data['phone']);
        $phone_number = $phone->formatE164();

        try {
            $user = $this->userRepository->getUserByPhone($phone_number);
        } catch (\Exception $e) {
            return $this->response(notification()->error('You have entered invalid phone/password', $e->getMessage()));
        }



        if (!Hash::check($form_data['password'], $user->password)) {
            return $this->response(notification()->error("You have entered invalid phone/password", 'You have entered invalid phone/password'));
        }

        return $this->responseData([
            'user' => $user,
            'access_token' => $this->tokenRepository->createAccessToken($user)
        ]);
    }

    public function check()
    {

        $form_data = clean_request([
            'phone' => 'phone'
        ]);


        $validator = Validator::make($form_data, [
            'phone' => ['required', 'regex:/^\+?[0-9]+$/', 'phone'],
        ]);

        if ($validator->errors()->count() > 0) {
            return  $this->responseValidation($validator);
        }

        $phone = phone($form_data['phone']);
        $phone_number = $phone->formatE164();


        $user = $this->userRepository->getUserByPhone($phone_number);


        if ($user) {
            if ($user->password) {
                return $this->responseData([
                    'redirect' => "PASSWORD_SCREEN",
                    'phone' => $user->phone
                ]);
            }

            return $this->responseData([
                'redirect' => "SEND_OTP_SCREEN",
                'user_token' =>  $user->token,
                'verify_drivers' => $this->otpRepository->getDrivers()
            ]);
        }

        $user = $this->userRepository->createUser($phone_number);

        return $this->responseData([
            'redirect' => "SEND_OTP_SCREEN",
            'user_token' =>  $user->token,
            'verify_drivers' => $this->otpRepository->getDrivers()
        ]);
    }
}
