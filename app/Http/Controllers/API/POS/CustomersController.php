<?php

namespace App\Http\Controllers\API\POS;

use App\Http\Controllers\Controller;
use App\Interfaces\CardRepositoryInterface;
use App\Interfaces\PosUserRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use twa\cmsv2\Traits\APITrait;
use Illuminate\Support\Facades\Validator;

class CustomersController extends Controller
{
    use APITrait;

    private UserRepositoryInterface $userRepository;
    private PosUserRepositoryInterface $posUserRepository;
    private CardRepositoryInterface $cardRepository;


    public function __construct(

        UserRepositoryInterface $userRepository,
        CardRepositoryInterface $cardRepository,
        PosUserRepositoryInterface $posUserRepository
    ) {
        $this->userRepository = $userRepository;
        $this->cardRepository = $cardRepository;
        $this->posUserRepository = $posUserRepository;
    }

    //HERE NOURHANE
    public function CreateUser()
    {

        $form_data = clean_request([]);


        $validator = Validator::make($form_data, [
            'phone' => ['required', 'regex:/^\+?[0-9]+$/', 'phone'],
            'password' => 'required',
            'full_name' => 'required',
            'email' => 'required|email',
        ]);

        if ($validator->errors()->count() > 0) {
            return  $this->responseValidation($validator);
        }

        $phone = phone($form_data['phone']);
        $phone_number = $phone->formatE164();

        $email = $form_data['email'];

        // $user_phone = $this->userRepository->getUserByPhone($phone_number);

       
        try {
            $this->userRepository->getUserByPhone($phone_number);
            return $this->response(notification()->error('You are already registered user', 'You are already registered user'));
        } catch (\Exception $th) {
            
        }



        $user_email = $this->userRepository->getUserByEmail($email);

        if ($user_email) {
            return $this->response(notification()->error('Email already registered', 'Email already registered'));
        }


        $user = $this->userRepository->createPosUser(
            $phone_number,
            $form_data["password"],
            $form_data["full_name"],
            $form_data["email"],
            $form_data["gender_id"] ?? null,
            $form_data["marital_status_id"] ?? null,
            $form_data["date_birth"] ?? null
        );

        $generated_barcode = $this->cardRepository->generateBarcode();
        if (isset($form_data['barcode']) && ($form_data['barcode'])) {
            $this->cardRepository->createCard($user, $form_data['barcode'], 'physical');
        } else {
            $this->cardRepository->createCard($user, $generated_barcode, 'physical');
        }
        return $this->responseData([
            'user_token' =>  $user->token,
        ]);
    }

    public function getPhone()
    {
        $form_data = clean_request([
            'phone' => 'phone',

        ]);

        $validator = Validator::make($form_data, [
            'phone' => ['required', 'regex:/^\+?[0-9]+$/', 'phone'],
        ]);

        if ($validator->errors()->count() > 0) {
            return $this->responseValidation($validator);
        }
        $phone = phone($form_data['phone']);

        $phone_number = $phone->formatE164();

        $user = $this->userRepository->getUserByPhone($phone_number);

        if (!$user) {
            return $this->responseData(notification()->error("User not found", "User not found"));
        }

        return $this->responseData($user);
    }


    public function editUser()
    {
        $form_data = clean_request();
        $validator = Validator::make($form_data, [
            'user_id' => ['required'],

        ]);
        if ($validator->errors()->count() > 0) {
            return  $this->responseValidation($validator);
        }

        $user = $this->userRepository->getUserById($form_data['user_id']);

        if (!$user) {
            return $this->responseData(notification()->error("User not found", "User not found"));
        }

        $updateData = [];


        if (isset($form_data['full_name'])) {
            $updateData['full_name'] = $form_data['full_name'];
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
        if (isset($form_data['gender_id'])) {
            $updateData['gender_id'] = $form_data['gender_id'];
        }

        if (isset($form_data['marital_status_id'])) {
            $updateData['marital_status_id'] = $form_data['marital_status_id'];
        }

        if (isset($form_data['date_birth'])) {
            $updateData['date_birth'] = $form_data['date_birth'];
        }

        User::whereNull('deleted_at')->where('id', $form_data['user_id'])
            ->update($updateData);

        return $this->response(notification()->success("User updated successfully!", "User updated successfully"));
    }
}
