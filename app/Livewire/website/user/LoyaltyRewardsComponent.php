<?php

namespace App\Livewire\Website\User;

use App\Interfaces\CardRepositoryInterface;
use App\Interfaces\RewardRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use twa\cmsv2\Traits\ToastTrait;

class LoyaltyRewardsComponent extends Component
{
    use ToastTrait;
    public $cinemaPrefix;
    public $langPrefix;
    public $user;
    public $card;
    public $rewardList;
    public $activeTab = 'loyalty';
    public $rewardId;
    public $redeemedRewards = [];


    private CardRepositoryInterface $cardRepository;
    private RewardRepositoryInterface $rewardRepository;

    public function __construct()
    {
        $this->cardRepository = app(CardRepositoryInterface::class);
        $this->rewardRepository = app(RewardRepositoryInterface::class);
    }


    public function mount($cinemaPrefix, $langPrefix)
    {
        $this->cinemaPrefix = $cinemaPrefix;
        $this->langPrefix = $langPrefix;
        $this->user = session('user');
        $this->card = $this->cardRepository->getActiveCard($this->user);
        $this->rewardList = $this->rewardRepository->getRewards($this->user);
        $this->redeemedRewards = session('redeemedRewards', []);
    }

    public function changeTab($tab)
    {
        $this->activeTab = $tab;
    }
    public function redeemReward($rewardId)
    {


        $this->rewardId = $rewardId;

        $reward = $this->rewardRepository->getRewardById($rewardId);


        if (!$reward) {
            $this->sendError("Reward not found", "Reward not found");

            return;
        }

        $redeemPoints = $reward->redeem_points;
        $userBalance = $this->cardRepository->getLoyaltyBalance($this->user);
        // dd($userBalance);
        if (($userBalance / $redeemPoints) < 1) {
            $this->sendError("Error", "Not enough balance to redeem this reward");
          
            return;
        }

        $userReward = $this->rewardRepository->getUsedReward($this->user->id, $reward->id);


        if ($userReward && $reward->one_time_usage == 1) {
            $this->sendError("Error", "Already redeemed");

          
            return;
        } elseif ($userReward && $userReward->used_at == null) {
            $this->sendError("Error", "Already redeemed");

        
            return;
        }

        try {
            DB::beginTransaction();

            $userReward = $this->rewardRepository->createUserReward($this->user->id, $reward->id);

            // dd($userReward);
            $this->cardRepository->createLoyaltyTransaction('out', $reward->redeem_points, $this->user, "Redeem Reward", $userReward->id);
            $this->redeemedRewards[$rewardId] = $userReward->code;
            session(['redeemedRewards' => $this->redeemedRewards]);
            DB::commit();
            $this->sendSuccess("Success", "Reward redeemed successfully");

           
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->sendError("Error", "Error while redeeming reward");
             
            
        }
    }
    public function render()
    {
        return view('livewire.website.user.loyalty-rewards-component');
    }
}
