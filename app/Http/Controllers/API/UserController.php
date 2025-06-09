<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Interfaces\TokenRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\CardRepositoryInterface;
use App\Interfaces\CartRepositoryInterface;
use App\Interfaces\OTPRepositoryInterface;
use App\Interfaces\ResetPasswordTokenRepositoryInterface;
use App\Models\ResetPasswordToken;
use App\Repositories\OrderRepository;
use App\Rules\UniqueEmail;
use App\Rules\UniquePhone;
use twa\cmsv2\Traits\APITrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{

    use APITrait;

    private TokenRepositoryInterface $tokenRepository;
    private UserRepositoryInterface $userRepository;
    private CardRepositoryInterface $cardRepository;
    private OTPRepositoryInterface $otpRepository;
    private ResetPasswordTokenRepositoryInterface $resetPasswordTokenRepository;
    private CartRepositoryInterface $cartRepository;
    private OrderRepository $orderRepository;


    public function __construct(TokenRepositoryInterface $tokenRepository, UserRepositoryInterface $userRepository, CardRepositoryInterface $cardRepository, OTPRepositoryInterface $otpRepository, ResetPasswordTokenRepositoryInterface $resetPasswordTokenRepository, CartRepositoryInterface $cartRepository, OrderRepository $orderRepository)
    {
        $this->tokenRepository = $tokenRepository;
        $this->userRepository = $userRepository;
        $this->cardRepository = $cardRepository;
        $this->otpRepository = $otpRepository;
        $this->resetPasswordTokenRepository = $resetPasswordTokenRepository;
        $this->cartRepository = $cartRepository;
        $this->orderRepository = $orderRepository;
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


    public function uploadProfileImage()
    {


        $form_data = clean_request();

        $validator = Validator::make($form_data, [
            'profile_picture' => 'required|image|mimes:jpg,jpeg,png,webp|mimetypes:image/jpeg,image/png,image/webp',
        ]);
        if ($validator->errors()->count() > 0) {
            return  $this->responseValidation($validator);
        }

        $user = request()->user;

        $image = $form_data['profile_picture'];
        $folder = uniqid();
        $extension = $image->getClientOriginalExtension();
        $originalFilename = $folder . '.' . $extension;


        $image->storeAs("public/data/{$folder}", 'thumb.webp');
        $image->storeAs("public/data/{$folder}", 'image.webp');


        $user->profile_picture = $originalFilename;
        $user->save();

        return $this->response(notification()->success('Profile Picture succesfully added', 'Profile Picture succesfully added'));
    }

    public function updateProfile()
    {

        $form_data = clean_request(['email' => 'email']);

        $user = request()->user;

        $updateData = [];

        $validation = [];


        if (isset($form_data['name'])) {
            $updateData['name'] = $form_data['name'];
            $validation['name'] = 'required|min:6';
        }
        if (isset($form_data['email'])) {
            $updateData['email'] = $form_data['email'];
            $updateData['email_verified_at']= now();
          
            $validation['email'] = ['required', 'email', new UniqueEmail($user->id)];
        }
        if (isset($form_data['phone'])) {
            $updateData['phone'] = $form_data['phone'];
            $validation['phone'] = ['required', 'phone', new UniquePhone($user->id)];
        }

        if (isset($form_data['gender'])) {
            $updateData['gender'] = $form_data['gender'];
            $validation['gender'] = 'required';
        }

        if (isset($form_data['dom'])) {
            $updateData['dom'] = $form_data['dom'];
            $validation['dom'] = 'required';
        }

        if (isset($form_data['dob'])) {
            $updateData['dob'] = $form_data['dob'];
            $validation['dob'] = 'required';
        }


        if (count($validation) > 0) {

            $validator = Validator::make($form_data, $validation);

            if ($validator->errors()->count() > 0) {
                return  $this->responseValidation($validator);
            }
        }

        if (count($updateData) > 0) {
            User::whereNull('deleted_at')->where('id', $user->id)
                ->update($updateData);

            return $this->response(notification()->success("User updated successfully!", "User updated successfully"));
        }


        return $this->response(notification()->success("User not updated!", "No data to update"));
    }


    public function completeProfile()
    {
        $form_data = clean_request(['email' => 'email']);

        $validator = Validator::make($form_data, [
            'name' => ['required', 'min:6'],
            'email' => [
                'required',
                'email',
                new UniqueEmail
            ],
        ]);
        if ($validator->errors()->count() > 0) {
            return  $this->responseValidation($validator);
        }

        $user = request()->user;
        $user->email = $form_data['email'];
        $user->email_verified_at = now();
        $user->name = $form_data['name'];
        $user->save();

        return $this->response(notification()->success('Profile succesfully completed', 'Profile succesfully completed'));
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
                'regex:/[@$!%*?&.]/',
            ],
            'confirm_password' => 'required|same:password'
        ]);

        if ($validator->fails()) {
            return  $this->responseValidation($validator);
        }

        $user = request()->user;

        // dd(md5($form_data['password']));
        // 64e39c60d69afe351b48472307add2c5
        // e817f2468050b328642e82ce4f756237
        if (md5($form_data['password']) === $user->password) {
            return $this->response(notification()->error('You have entered an already existing password', 'You have entered an already existing password'), 403);
        }

        if (md5($form_data['current_password']) !== $user->password) {
            return $this->response(notification()->error('Current password is incorrect', 'Current password is incorrect'), 403);
        }

        $this->userRepository->changePassword($user, $form_data['password']);

        return $this->response(notification()->success('Password succesfully changed', 'Password succesfully changed'));
    }
    public function forgetPassword()
    {
        $form_data = clean_request(['phone' => 'phone']);

        $validator = Validator::make($form_data, [
            'phone' => ['required', 'regex:/^\+?[0-9]+$/', 'phone'],
        ]);

        if ($validator->fails()) {
            return $this->responseValidation($validator);
        }

        $user = $this->userRepository->getVerifiedUserByPhone($form_data['phone']);
    
        if(!$user){
            return $this->response(notification()->error('Incorrect Credentials', 'You have entered invalid phone/password or not verified'));
        }

        if(!$user->email){
            return $this->response(notification()->error('Email Required', 'Your account does not have an email address'));
        }


        //send an email

        
        return $this->responseData([
            'user_token' =>  $user->token,
            'verify_drivers' => $this->otpRepository->getDrivers(),
        ]);
    }


    public function resetPassword()
    {
        $form_data = clean_request([]);
        $validator = Validator::make($form_data, [
            'password' => [
                'required',
                'min:8',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*?&.]/',
            ],
            'confirm_password' => 'required|same:password',
            'reset_token' => 'required'

        ]);

        if ($validator->fails()) {
            return $this->responseValidation($validator);
        }
        $reset_token = $this->resetPasswordTokenRepository->check($form_data['reset_token']);

        if (!$reset_token) {
            return $this->response(notification()->error('Invalid or expired token', 'Invalid or expired token'));
        }

        try {
            $user = $this->userRepository->getUserById($reset_token->user_id);
        } catch (\Exception $e) {
            return $this->response(notification()->error('User not found', $e->getMessage()));
        }

        
        if (md5($form_data['password']) === $user->password) {
            return $this->response(notification()->error('You have entered an already existing password', 'You have entered an already existing password'), 403);
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

    public function rechargeWallet()
    {

        $form_data = clean_request([]);
        $check = $this->validateRequiredFields($form_data, ['amount', 'payment_method_id']);

        if ($check) {
            return $this->response($check);
        }

        $user = request()->user;
        $user_type = request()->user_type;


        try {
            $system_id = get_system_from_type($user_type);
        } catch (\Throwable $th) {
            return  $this->response(notification()->error("Error", $th->getMessage()));
        }


        // dd($form_data);

       
        $timer = 30; 
        
    
        try {
            $cart = $this->cartRepository->createCart($user->id, $user_type, $system_id, $timer);
        } catch (\Exception $th) {
            return $this->response(notification()->error("Error", $th->getMessage()));
        }



        $minimum_recharge_amount = get_setting("minimum_topup_amount");
        $maximum_recharge_amount =  get_setting("maximum_topup_amount");


        if ($form_data['amount'] < $minimum_recharge_amount) {
            return $this->response(notification()->error('Invalid Amount', "Please enter amount greater than " . $minimum_recharge_amount));
        }
        if ($form_data['amount'] > $maximum_recharge_amount) {
            return $this->response(notification()->error('Invalid Amount', "Please enter amount less than " . $maximum_recharge_amount));
        }


        try {
            $this->cartRepository->addTopupToCart($cart->id, $form_data['amount']);
        } catch (\Exception $th) {
            return $this->response(notification()->error('Error adding amount to cart', $th->getMessage()));
        }


        try {
            $payment_method = $this->orderRepository->getPaymentMethodById($form_data['payment_method_id']);
        } catch (\Exception $th) {
            return $this->response(notification()->error('Payment Method Not Found', $th->getMessage()));
        }


        if (!str($payment_method->key)->contains('OP')) {
            return $this->response(notification()->error('Payment Method Not Supported', 'Payment Method Not Supported'));
        }


        try {
            $order = app(\App\Http\Controllers\API\OrderController::class);
            return $order->createOrder($cart->id, $payment_method);
        } catch (\Exception $e) {
            return $this->response(notification()->error('Order Attempt Failed', $e->getMessage()));
        }
    }

    public function setPlayer()
    {
        $form_data = clean_request([]);

        $check = $this->validateRequiredFields($form_data, ['player_id']);
        if ($check) {
            return $this->response($check);
        }

        $user = request()->user;

        if ($user) {
            $user->player_id = $form_data['player_id'];
            $user->save();

            return $this->response(notification()->error('Player ID updated successfully.', 'Player ID updated successfully.'));
        }

        // return $this->response(['error' => 'User not found.'], 404);
    }
}
