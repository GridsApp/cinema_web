<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Interfaces\CardRepositoryInterface;
use App\Interfaces\HovigRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use twa\cmsv2\Traits\APITrait;


class CardController extends Controller
{
    use APITrait;
    private CardRepositoryInterface $cardRepository;
    private UserRepositoryInterface $userRepository;
    private HovigRepositoryInterface $hovigRepository;

    public function __construct(
        CardRepositoryInterface $cardRepository,
        UserRepositoryInterface $userRepository,
        HovigRepositoryInterface $hovigRepository

    ) {
        $this->cardRepository = $cardRepository;
        $this->userRepository = $userRepository;
        $this->hovigRepository = $hovigRepository;
    }

    public function getCardInfo()
    {

        $form_data = clean_request([]);
        $validator = Validator::make($form_data, [
            'barcode' => 'required',
        ]);



        if ($validator->errors()->count() > 0) {
            return  $this->responseValidation($validator);
        }
        try {
            $card =  $this->cardRepository->getCardByBarcode($form_data['barcode']);
        } catch (\Exception $e) {
            return $this->response(notification()->error('Invalid barcode', $e->getMessage()));
        }
        try {

            $user = $this->userRepository->getUserById($card->user_id);
        } catch (\Exception $e) {
            return $this->response(notification()->error('User not found', $e->getMessage()));
        }

        $activeCard = $this->cardRepository->getActiveCard($user);

        if (!$activeCard) {
            return $this->response(notification()->error("'No active card found for this user", "No active card found for this user"));
        }

        $activeCard["loyalty_transactions"] = $this->cardRepository->getLoyaltyTransactions($user);
        $activeCard["wallet_transactions"] = $this->cardRepository->getWalletTransactions($user);

        return $this->responseData([
            $activeCard
        ]);
    }

    public function updateUserCard()
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
        } catch (\Exception $e) {
            return $this->response(notification()->error('User not found', $e->getMessage()));
        }
        $updateData = [];


        if (isset($form_data['barcode'])) {
            $updateData['barcode'] = $form_data['barcode'];
        }

        try {
            $existingBarcode = $this->cardRepository->checkIfBarcodeExists($form_data['barcode']);

            if ($existingBarcode) {
                return $this->responseData(notification()->error("Barcode already exists", "The barcode is already in use by another user."));
            }
        } catch (\Throwable $th) {
            //throw $th;
        }


        $this->cardRepository->updateUserCard($form_data['user_id'], $updateData);


        return $this->response(notification()->success("User Card updated successfully!", "User Card updated successfully"));
    }

    public function test()
    {
        return $this->hovigRepository->getFirstName();
    }
}
