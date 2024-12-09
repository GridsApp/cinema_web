<?php

namespace App\Interfaces;

interface RewardRepositoryInterface 
{
   
    public function getRewards($user);
    public function getRewardById($reward_id);
    public function getUsedReward($user_id , $reward_id);
    public function getUsedRewards($user_id);
    public function createUserReward($user_id,$reward_id);
}