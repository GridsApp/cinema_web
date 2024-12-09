<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Interfaces\CardRepositoryInterface;
use App\Interfaces\RewardRepositoryInterface;
use App\Traits\APITrait;
use Illuminate\Support\Facades\DB;

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
          
            $this->cardRepository->createLoyaltyTransaction('out' , $reward->redeem_points , $user , "Redeem Reward" , $user_reward->id);
          

            DB::commit();

        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->response(notification()->error('Error', $th->getMessage()));
        }

        return $this->response(notification()->success('Reward Redeemed successfully', 'Reward Redeemed successfully'));
    }
}
