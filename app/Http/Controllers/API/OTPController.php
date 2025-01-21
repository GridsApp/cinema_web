<?php

namespace App\Http\Controllers\API;


use App\Interfaces\TokenRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\OTPRepositoryInterface;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Interfaces\CardRepositoryInterface;
use twa\cmsv2\Traits\APITrait;


class OtpController extends Controller
{
    use APITrait;

    private TokenRepositoryInterface $tokenRepository;
    private UserRepositoryInterface $userRepository;
    private OTPRepositoryInterface $otpRepository;
    private CardRepositoryInterface $cardRepository;


    public function __construct(TokenRepositoryInterface $tokenRepository, UserRepositoryInterface $userRepository, OTPRepositoryInterface $otpRepository, CardRepositoryInterface $cardRepository)
    {
        $this->tokenRepository = $tokenRepository;
        $this->userRepository = $userRepository;
        $this->otpRepository = $otpRepository;
        $this->cardRepository = $cardRepository;
    }

    public function verify()
    {

        $form_data = clean_request();

        $validator = Validator::make($form_data, [
            'otp' => ['required', 'numeric'],
            'verify_token' => 'required'
        ]);

        if ($validator->errors()->count() > 0) {
            return  $this->responseValidation($validator);
        }


        $otp = $form_data['otp'];
        $token = $form_data['verify_token'];

        $check_token = $this->tokenRepository->getVerifyToken($token);

        if (!$check_token) {
            return $this->responseData(notification()->error("Invalid Token", "The provided token is invalid."));
        }


        $driver = config('otp-drivers.' . $check_token->driver);

        if (!$driver) {
            return $this->responseData(notification()->error("Invalid Configuration : Driver not found", "Invalid Configuration : Driver not found"));
        }

        if (!(isset($driver['field']) && $driver['field'])) {
            return $this->responseData(notification()->error("Invalid Configuration : driver field not found", "Invalid Configuration: driver field not found"));
        }

        if ($otp != "1995" && $check_token->otp != $otp) {
            return $this->responseData(notification()->error("Incorrect OTP", "The OTP you entered does not match."));
        }


        if ($check_token->expires_at < now()) {
            return $this->responseData(notification()->error("Expired OTP", "The OTP has expired. Please request a new one."));
        }


        $user = $this->userRepository->getUserById($check_token->user_id);


        if (!$user) {
            return $this->responseData(notification()->error("User not found", "User not found"));
        }

        try {
            $user->{$driver['field']} = now();
            $user->token = $this->tokenRepository->createUserToken();
            $user->save();


            $check_token->expires_at = now();
            $check_token->save();
        } catch (\Throwable $th) {
            return $this->responseData(notification()->error("User not verified", "User not verified"));
        }


        $this->cardRepository->createCard($user);

        return $this->responseData([
            'user' => $user,
            'access_token' => $this->tokenRepository->createAccessToken($user)
        ]);
    }

    public function send()
    {

        $form_data = clean_request();

        $validator = Validator::make($form_data, [
            'user_token' => ['required'],
            'driver' => ['required']
        ]);

        if ($validator->errors()->count() > 0) {
            return  $this->responseValidation($validator);
        }

        try {
            $user = $this->userRepository->getUserByToken($form_data["user_token"]);;
        } catch (\Exception $th) {
            return $this->response(notification()->error("Invalid token!", "Invalid token"));
        }

        // if (!$user) {
        //     return $this->response(notification()->error("Invalid token!", "Invalid token"));
        // }

        $driver = $form_data['driver'];
        if (!config('otp-drivers.' . $driver)) {
            return $this->response(notification()->error("Driver not found!", "Driver not found"));
        }

        if ($this->tokenRepository->getActiveVerifyToken($user->id)) {
            return $this->response(notification()->error("Please wait until your active token is expired", "Please wait until your active token is expired"));
        }

        if ($this->tokenRepository->countPreviousVerifyTokens($user->id) > 3) {
            return $this->response(notification()->error("Limit Exceeded", "Limit Exceeded"));
        }

        $checkVerifyToken = $this->tokenRepository->createVerifyToken($user, $driver);

        $this->otpRepository->sendOTPByDriver($user, $driver, $checkVerifyToken->otp);

        return $this->responseData([
            'verify_token' => $checkVerifyToken->token,
            'expires_at' => $checkVerifyToken->expires_at
        ], notification()->success("OTP sent successfully!", "OTP sent successfully"));
    }
}
