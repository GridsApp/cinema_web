<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Interfaces\CardRepositoryInterface;
use App\Interfaces\RewardRepositoryInterface;
use App\Models\Reward;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use twa\cmsv2\Traits\APITrait;

class RewardController extends Controller
{
    use APITrait;


    private RewardRepositoryInterface $rewardRepository;
    private CardRepositoryInterface $cardRepository;

    public function __construct(CardRepositoryInterface $cardRepository, RewardRepositoryInterface $rewardRepository)
    {
        $this->rewardRepository = $rewardRepository;
        $this->cardRepository = $cardRepository;
    }

    public function list()
    {
        $user = request()->user;

        $reward_list = $this->rewardRepository->getRewards($user);

        return $this->responseData($reward_list);
    }

    public function posRedeemCode()
    {



        $user = request()->user;
        $user_type = request()->user_type;
        // dd($user);
        $form_data = clean_request([]);
        $validator = Validator::make($form_data, [
            'code' => 'required',
        ]);



        if ($validator->errors()->count() > 0) {
            return  $this->responseValidation($validator);
        }
        // $user = request()->user;
        $user_reward = $this->rewardRepository->getRewardByCode($form_data['code']);

        if (!$user_reward) {
            return $this->response(notification()->error('Code Not Found', 'Code Not Found'));
        }
        $user_reward->used_at = now();
        $user_reward->save();


        // dd($user->branch->label_en);

        $reward = Reward::whereNull('deleted_at')->where('id',$user_reward->reward_id)->first();
        // dd($reward);
        return $this->responseData([
            'reward_id' =>$user_reward->reward_id,
            'label' => $reward->title,
            'description' => $reward->description,
            'code' => $user_reward->code,
            'cashier' => $user->name,
            'branch'=>[
                'label_en'=>$user->branch->label_en,
                'label_ar'=>$user->branch->label_ar,
            ]

        ]);
        // return $this->response(notification()->success('Code Used Successfully', 'Code has been successfully Used.'));


        // $user_reward =   $this->rewardRepository->getUsedReward($user->id, $reward->id);


        // if ($user_reward && $reward->one_time_usage == 1) {
        //     return $this->response(notification()->error('Already redeemed', "You have already redeemed this reward'"));
        // } elseif ($user_reward && $user_reward->used_at == null) {
        //     return $this->response(notification()->error('Already redeemed', "You have already redeemed this reward'"));
        // }


        // try {
        //     DB::beginTransaction();

        //     $user_reward = $this->rewardRepository->createUserReward($user->id, $reward->id);

        //     $this->cardRepository->createLoyaltyTransaction('out', $reward->redeem_points, $user, "Redeem Reward", $user_reward->id);


        //     DB::commit();
        // } catch (\Throwable $th) {
        //     DB::rollBack();
        //     return $this->response(notification()->error('Error', $th->getMessage()));
        // }


    }


    public function redeem($reward_id)
    {

        $user = request()->user;
        $reward = $this->rewardRepository->getRewardById($reward_id);

        if (!$reward) {
            return $this->response(notification()->error('Reward Not Found', 'Reward Not Found'));
        }
        $redeem_points = $reward->redeem_points;

        $user_balance = $this->cardRepository->getLoyaltyBalance($user);

        if (($user_balance / $redeem_points) < 1) {
            return $this->response(notification()->error('Not enough balance to redeem this reward', "Not enough balance to redeem this reward'"));
        }


        $user_reward =   $this->rewardRepository->getUsedReward($user->id, $reward->id);


        if ($user_reward && $reward->one_time_usage == 1) {
            return $this->response(notification()->error('Already redeemed', "You have already redeemed this reward'"));
        } elseif ($user_reward && $user_reward->used_at == null) {
            return $this->response(notification()->error('Already redeemed', "You have already redeemed this reward'"));
        }


        try {
            DB::beginTransaction();

            $user_reward = $this->rewardRepository->createUserReward($user->id, $reward->id);

            $this->cardRepository->createLoyaltyTransaction('out', $reward->redeem_points, $user, "Redeem Reward", $user_reward->id);


            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->response(notification()->error('Error', $th->getMessage()));
        }

        return $this->response(notification()->success('Reward Redeemed successfully', 'Reward Redeemed successfully'));
    }
}
