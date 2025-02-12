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
use twa\cmsv2\Traits\APITrait;


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

        if ($validator->errors()->count() > 0) {
            return  $this->responseValidation($validator);
        }

        $phone = phone($form_data['phone']);
        $phone_number = $phone->formatE164();

        try {
            $user = $this->userRepository->getUserByPhone($phone_number);
        } catch (\Exception $e) {
            $user = $this->userRepository->createUser($phone_number, $form_data["password"]);
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
            $user = $this->userRepository->getVerifiedUserByPhone($phone_number);
        } catch (\Exception $e) {
            return $this->response(notification()->error('You have entered invalid phone/password or not verified', $e->getMessage()));
        }


        // dd($user->password);
        if (!Hash::check($form_data['password'], $user->password)) {
            return $this->response(notification()->error("You have entered invalid phone/password or not verified", 'You have entered invalid phone/password or not verified'));
        }


        return $this->responseData([
            'user' => $user->format(),
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


        $user = $this->userRepository->getVerifiedUserByPhone($phone_number);


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

    public function loginUsingProvider()
    {

        $form_data = clean_request([]);


        $validator = Validator::make($form_data, [
            'email' => 'email',
            'identifier' => 'required',
            'login_provider' => 'required',
            'signature' => 'required',
            'token' => 'required',

        ]);

        if ($validator->fails()) {
            return $this->responseValidation($validator);
        }


        if ($form_data['signature'] !== md5($form_data['login_provider'] . $form_data['token'])) {
            return $this->response(notification()->error('Signature did not match', 'Signature did not match'));
        }


        $login_provider = strtolower($form_data['login_provider']);
        $identifier = $form_data['identifier'];
        $email = $form_data['email'];


        $user = null;
        if (!empty($email)) {
            $user = User::where("email", $email)->whereNull('deleted_at')->first();
        }

        if (!$user && !empty($identifier)) {
            $user = User::where('identifier', $identifier)->whereNull('deleted_at')->first();
        }

        if (!$user) {
            $user = new User();
            $user->name = $form_data['name'];
            $user->email = $form_data['email'];
            $user->login_provider = $login_provider;
            $user->token = $this->tokenRepository->createUserToken();
        }

        $user->identifier = $identifier;
        $user->login_provider = $login_provider;
        $user->save();

        $access_token = $this->tokenRepository->createAccessToken($user);
        $this->cardRepository->createCard($user);


        return $this->responseData([
            'user' => $user,
            'access_token' => $access_token,
        ]);
    }
}
