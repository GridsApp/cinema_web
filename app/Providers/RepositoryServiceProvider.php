<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {

        $this->app->bind(\App\Interfaces\MovieRepositoryInterface::class, \App\Repositories\MovieRepository::class);
        $this->app->bind(\App\Interfaces\MovieShowRepositoryInterface::class, \App\Repositories\MovieShowRepository::class);
        $this->app->bind(\App\Interfaces\BranchRepositoryInterface::class, \App\Repositories\BranchRepository::class);
    
        $this->app->bind(\App\Interfaces\OTPRepositoryInterface::class, \App\Repositories\OTPRepository::class);
        $this->app->bind(\App\Interfaces\UserRepositoryInterface::class, \App\Repositories\UserRepository::class);
        $this->app->bind(\App\Interfaces\TokenRepositoryInterface::class, \App\Repositories\TokenRepository::class);
        $this->app->bind(\App\Interfaces\CardRepositoryInterface::class, \App\Repositories\CardRepository::class);

        $this->app->bind(\App\Interfaces\OmniPayRepositoryInterface::class, \App\Repositories\OmniPayRepository::class);
        $this->app->bind(\App\Interfaces\RewardRepositoryInterface::class, \App\Repositories\RewardRepository::class);
        $this->app->bind(\App\Interfaces\CartRepositoryInterface::class, \App\Repositories\CartRepository::class);
        $this->app->bind(\App\Interfaces\TheaterRepositoryInterface::class, \App\Repositories\TheaterRepository::class);
        $this->app->bind(\App\Interfaces\ItemRepositoryInterface::class, \App\Repositories\ItemRepository::class);
        $this->app->bind(\App\Interfaces\OrderRepositoryInterface::class, \App\Repositories\OrderRepository::class);

        $this->app->bind(\App\Interfaces\ZoneRepositoryInterface::class , \App\Repositories\ZoneRepository::class);
        $this->app->bind(\App\Interfaces\PosUserRepositoryInterface::class , \App\Repositories\PosUserRepository::class);
        $this->app->bind(\App\Interfaces\KioskUserRepositoryInterface::class , \App\Repositories\KioskUserRepository::class);
        $this->app->bind(\App\Interfaces\TicketRepositoryInterface::class , \App\Repositories\TicketRepository::class);

        $this->app->bind(\App\Interfaces\CouponRepositoryInterface::class , \App\Repositories\CouponRepository::class);
        $this->app->bind(\App\Interfaces\PriceGroupZoneRepositoryInterface::class , \App\Repositories\PriceGroupZoneRepository::class);
        $this->app->bind(\App\Interfaces\MovieReviewRepositoryInterface::class , \App\Repositories\MovieReviewRepository::class);
        $this->app->bind(\App\Interfaces\ResetPasswordTokenRepositoryInterface::class , \App\Repositories\ResetPasswordTokenRepository::class);
        $this->app->bind(\App\Interfaces\HovigRepositoryInterface::class , \App\Repositories\HovigRepository::class);

        
        

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        
    }
}
