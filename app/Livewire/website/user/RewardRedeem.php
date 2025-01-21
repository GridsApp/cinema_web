<?php

namespace App\Livewire\Website\User;

use Livewire\Component;

use Illuminate\Support\Facades\DB;

class RewardRedeem extends Component
{
    public $cinemaPrefix;
    public $langPrefix;
    public $reward_id;
    public $user;
    public $reward;

    public function mount($cinemaPrefix, $langPrefix,$reward_id = null)
    {
        // dd($reward_id); // Debugging the reward_id to ensure it's being passed
        $this->cinemaPrefix = $cinemaPrefix;
        $this->langPrefix = $langPrefix;
        $this->reward_id = $reward_id; // Assigning the passed reward_id
        $this->user = session('user');
        $this->reward = $this->rewardRepository->getRewardById($this->reward_id);
    }
    

    public function redeem($reward_id)
    {
       
        // The method will now receive $reward_id from the Livewire call
        $user = session('user');
        $reward = $this->rewardRepository->getRewardById($reward_id);

        if (!$reward) {
            session()->flash('error', 'Reward not found');
            return;
        }
        $redeem_points = $reward->redeem_points;

        $user_balance = $this->cardRepository->getLoyaltyBalance($user);

        if (($user_balance / $redeem_points) < 1) {
            session()->flash('error', 'Not enough balance to redeem this reward');
            return;
        }

        $user_reward = $this->rewardRepository->getUsedReward($user->id, $reward->id);

        if ($user_reward && $reward->one_time_usage == 1) {
            session()->flash('error', 'Already redeemed');
            return;
        } elseif ($user_reward && $user_reward->used_at == null) {
            session()->flash('error', 'Already redeemed');
            return;
        }

        try {
            DB::beginTransaction();

            $user_reward = $this->rewardRepository->createUserReward($user->id, $reward->id);
            $this->cardRepository->createLoyaltyTransaction('out', $reward->redeem_points, $user, "Redeem Reward", $user_reward->id);

            DB::commit();

            session()->flash('success', 'Reward redeemed successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', 'Error while redeeming reward');
        }
    }


    public function render()
    {
        return view('livewire.website.user.reward-redeem');
    }
}
