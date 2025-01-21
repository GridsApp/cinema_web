<?php

namespace App\Repositories;

use App\Interfaces\CardRepositoryInterface;
use App\Interfaces\RewardRepositoryInterface;
use App\Models\Reward;
use App\Models\UserReward;

class RewardRepository implements RewardRepositoryInterface
{



   
    private CardRepositoryInterface $cardRepository;

    public function __construct(CardRepositoryInterface $cardRepository)
    {
        $this->cardRepository = $cardRepository;
    }


    public function getRewards($user)
    {

        $user_balance = $this->cardRepository->getLoyaltyBalance($user);

        $used_rewards = $this->getUsedRewards($user->id);

        $rewards = Reward::all();
        $reward_list = $rewards->map(function ($reward) use ($user_balance , $used_rewards) {
            $redeem_points = $reward->redeem_points;
            
            $percrentage = ($user_balance  / $redeem_points  ) * 100;
            $percrentage = $percrentage > 100 ? 100 : $percrentage;

            return [
                'id' => $reward->id,
                'title' => $reward->title,
                'redeem_points' => $redeem_points,
                'image' => get_image($reward->image),
                'description' => $reward->description,
                'one_time_usage' => $reward->one_time_usage,
                'percentage' => $percrentage,
                'remaining_points' => $percrentage == 100 ? 0 : $redeem_points - $user_balance,
                'code' => $used_rewards[$reward->id] ?? null,
                'user_balance' => (double) $user_balance
            ];
        });

        
        return $reward_list;
    }
    public function getRewardById($reward_id)
    {

        return Reward::find($reward_id);
    }

    public function getRewardByCode($code)
    {

        return UserReward::whereNull('deleted_at')->whereNull('used_at')->where('code',$code)->first();

        // dd($user_reward);
    }


    public function getUsedReward($user_id,$reward_id)
    {
        return  UserReward::whereNull('deleted_at')->where('user_id', $user_id)->where('reward_id', $reward_id)->first();
    }

    public function getUsedRewards($user_id)
    {
        return  UserReward::whereNull('deleted_at')->where('user_id', $user_id)->whereNull('used_at')->pluck('code' , 'reward_id');
    }


    public function createUserReward($user_id,$reward_id) {
        $reward = new UserReward;
        $reward->user_id = $user_id;
        $reward->reward_id = $reward_id;
        $reward->code = $this->generateRedeemCode();
       
        $reward->save();

        return $reward;
    }

    public function generateRedeemCode()
    {
        do {
            $code = str(str()->random(14))->upper();
        } while (UserReward::where('code', $code)->whereNull('deleted_at')->exists());
    
        return $code;
    }
    
}
