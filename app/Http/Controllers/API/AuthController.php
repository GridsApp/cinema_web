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


        // Here

        $validator = Validator::make($form_data, [
            'phone' => ['required', 'regex:/^\+?[0-9]+$/', 'phone'],
            'password' => [
                'required',
                'min:8',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
                'regex:/[@#$!%*?&.]/',
            ],
            'confirm_password' => 'required|same:password'
        ]);

        if ($validator->errors()->count() > 0) {
            return  $this->responseValidation($validator);
        }

        $phone = phone($form_data['phone']);
        $phone_number = $phone->formatE164();


        $user = $this->userRepository->getVerifiedUserByPhone($phone_number);

        if($user){
            return $this->response(notification()->error('Already registered' , 'This account is already registered'));
        }

        $user = $this->userRepository->createVerifiedUser($phone_number, $form_data["password"]);

        $this->cardRepository->createCard($user);

        return $this->responseData([
            'user' => $user->format(),
            'access_token' => $this->tokenRepository->createAccessToken($user)
        ]);


        // return $this->responseData([
        //     'user_token' =>  $user->token,
        //     'verify_drivers' => $this->otpRepository->getDrivers(),
        // ]);
    }

    public function login()
    {


        $form_data = clean_request([
            'phone' => 'phone'
        ]);

        $validator = Validator::make($form_data, [
            // 'phone' => ['required', 'regex:/^\+?[0-9]+$/', 'phone'],
            // 'password' => 'required'

            'phone' => ['required', 'regex:/^\+?[0-9]+$/', 'phone'],
            'password' => [
                'required',
            ],
        ]);

        if ($validator->errors()->count() > 0) {
            return  $this->responseValidation($validator);
        }

        $phone = phone($form_data['phone']);
        $phone_number = $phone->formatE164();


        $user = $this->userRepository->getVerifiedUserByPhone($phone_number);

        if(!$user){
            return $this->response(notification()->error("Yoou have entered invalid phone/password or not verified", 'You have entered invalid phone/password or not verified'));
        }

        if (md5($form_data['password']) != $user->password) {
            return $this->response(notification()->error("You have entered invalid phone/password or not verified", 'You have entered invalid phone/password or not verified'));
        }

        return $this->responseData([
            'user' => $user->format(),
            'access_token' => $this->tokenRepository->createAccessToken($user)
        ]);
    }

    public function check()
    {


        // We removed the validation


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
        $form_data = clean_request([
            'email' => 'email',
            'identifier' => 'string',
            'login_provider' => 'string',
            'signature' => 'string',
            'token' => 'string',
            'name' => 'string'
        ]);

        $validator = Validator::make($form_data, [
            'identifier' => 'required',
            'login_provider' => 'required',
            'signature' => 'required',
            'token' => 'required',
            'email' => 'nullable|email',
            'name' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return $this->responseValidation($validator);
        }

        if ($form_data['signature'] !== md5($form_data['login_provider'] . $form_data['token'])) {
            return $this->response(notification()->error('Signature did not match', 'Signature did not match'));
        }

        $login_provider = strtolower($form_data['login_provider']);
        $identifier = $form_data['identifier'];
        $email = $form_data['email'] ?? null;

        $user = null;
        if (!empty($email)) {
            $user = User::where("email", $email)->whereNull('deleted_at')->first();
        }

        if (!$user && !empty($identifier)) {
            $user = User::where('identifier', $identifier)->whereNull('deleted_at')->first();
        }

        if (!$user) {
            $user = new User();
            $user->name = $form_data['name'] ?? null;
            $user->email = $email;
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
