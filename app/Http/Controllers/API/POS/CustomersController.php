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
    public function createUser()
    {

        $form_data = clean_request([]);


        $validator = Validator::make($form_data, [
            'phone' => ['required', 'regex:/^\+?[0-9]+$/', 'phone'],
            'password' => 'required',
            'name' => 'required',
            'email' => 'required|email',
        ]);

        if ($validator->errors()->count() > 0) {
            return  $this->responseValidation($validator);
        }

        $phone = phone($form_data['phone']);
        $phone_number = $phone->formatE164();

        $email = $form_data['email'];

    
        try {
            $this->userRepository->getUserByPhone($phone_number);
            return $this->response(notification()->error('You are already registered user', 'You are already registered user'));
        } catch (\Exception $th) {
            
        }


        try {
            $this->userRepository->getUserByEmail($email);
            return $this->response(notification()->error('Email already registered', 'Email already registered'));
        } catch (\Exception $th) {
            
        }

      
        $user = $this->userRepository->createCustomer(
            $phone_number,
            $form_data["password"],
            $form_data["name"],
            $form_data["email"],
            $form_data["gender"] ?? null,
            $form_data["dom"] ?? null,
            $form_data["dob"] ?? null
        );

        $generated_barcode = $this->cardRepository->generateBarcode();
        if (isset($form_data['barcode']) && ($form_data['barcode'])) {
            $this->cardRepository->createCard($user, $form_data['barcode'], 'physical');
        } else {
            $this->cardRepository->createCard($user, $generated_barcode, 'physical');
        }
        return $this->response(notification()->success("User added" , "User was successfully added"));
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

        try {
            $user = $this->userRepository->getUserByPhone($phone_number);
        } catch (\Throwable $th) {
            return $this->response(notification()->error("User not found", "User not found"));
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
}
