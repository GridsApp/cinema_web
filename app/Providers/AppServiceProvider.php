<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
       
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {

  
   
            $conditions = [
               
                'theater' => [
                    [
                        'type' => 'where',
                        'column' => 'branches.id',
                        'operand' => null,
                        'value' => $cms_user->branch->id ?? null,  
                    ],
                ],
                
        
            ];

        
            Config::set('app.dynamic_conditions', $conditions);
        }
    }


