<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Interfaces\CardRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use App\Models\UserCard;
use Illuminate\Support\Facades\Validator;



use twa\cmsv2\Traits\APITrait;


class CardController extends Controller
{


    use APITrait;

    private CardRepositoryInterface $cardRepository;
    private UserRepositoryInterface $userRepository;

    public function __construct(
        CardRepositoryInterface $cardRepository,
        UserRepositoryInterface $userRepository

    ) {
        $this->cardRepository = $cardRepository;
        $this->userRepository = $userRepository;
    }

    public function getCardInfo()
    {
        // dd("here");
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
            return $this->responseData(notification()->error("'No active card found for this user", "No active card found for this user"));
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
        // if (!$user) {
        //     return $this->responseData(notification()->error("User not found", "User not found"));
        // }

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

        // $existingBarcode = UserCard::whereNull('deleted_at')->where('barcode', $form_data['barcode'])->exists();

        // if ($existingBarcode) {
        //     return $this->responseData(notification()->error("Barcode already exists", "The barcode is already in use by another user."));

        // }
        $this->cardRepository->updateUserCard($form_data['user_id'], $updateData);

        // UserCard::whereNull('deleted_at')->where('user_id', $form_data['user_id'])
        //     ->update($updateData);

        return $this->response(notification()->success("User Card updated successfully!", "User Card updated successfully"));
    }
}
