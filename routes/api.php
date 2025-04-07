<?php

use App\Http\Middleware\AuthMandatoryMiddleware;
use App\Http\Middleware\POSUserMiddleware;
use twa\cmsv2\Http\Middleware\LanguageMiddleware;
use App\Http\Middleware\AuthOptionalMiddleware;
use App\Http\Middleware\UserMiddleware;
use Illuminate\Support\Facades\Route;



Route::group(['prefix' => 'v1', 'middleware' => LanguageMiddleware::class], function () {

    Route::prefix('auth')->group(function () {

    // dd("here");
        Route::prefix('user')->group(function () {
            Route::post('set-player', [App\Http\Controllers\API\UserController::class, 'setPlayer'])->middleware([AuthMandatoryMiddleware::class]);

            Route::get('account', [App\Http\Controllers\API\UserController::class, 'getAccount'])->middleware([AuthMandatoryMiddleware::class, UserMiddleware::class]);
            Route::post('complete-profile', [App\Http\Controllers\API\UserController::class, 'completeProfile'])->middleware([AuthMandatoryMiddleware::class, UserMiddleware::class]);

            Route::post('update-profile', [App\Http\Controllers\API\UserController::class, 'updateProfile'])->middleware([AuthMandatoryMiddleware::class, UserMiddleware::class]);

            Route::post('upload-image', [App\Http\Controllers\API\UserController::class, 'uploadProfileImage'])->middleware([AuthMandatoryMiddleware::class, UserMiddleware::class]);

            Route::post('change-password', [App\Http\Controllers\API\UserController::class, 'changePassword'])->middleware([AuthMandatoryMiddleware::class, UserMiddleware::class]);
            Route::post('delete-account', [App\Http\Controllers\API\UserController::class, 'deleteAccount'])->middleware([AuthMandatoryMiddleware::class, UserMiddleware::class]);
            Route::get('wallet-transactions', [App\Http\Controllers\API\CardController::class, 'getWalletTransactions'])->middleware([AuthMandatoryMiddleware::class, UserMiddleware::class]);
            Route::get('loyalty-transactions', [App\Http\Controllers\API\CardController::class, 'getLoyaltyTransactions'])->middleware([AuthMandatoryMiddleware::class, UserMiddleware::class]);
            Route::post('recharge-wallet', [App\Http\Controllers\API\UserController::class, 'rechargeWallet'])->middleware([AuthMandatoryMiddleware::class, UserMiddleware::class]);



            Route::get('/rewards', [App\Http\Controllers\API\RewardController::class, 'list'])->middleware([AuthMandatoryMiddleware::class, UserMiddleware::class]);
            Route::post('rewards/{reward_id}/redeem', [App\Http\Controllers\API\RewardController::class, 'redeem'])->middleware([AuthMandatoryMiddleware::class, UserMiddleware::class]);

            Route::prefix('tickets/list')->group(function () {
                Route::get('history', [App\Http\Controllers\API\TicketsController::class, 'history'])->middleware([AuthMandatoryMiddleware::class, UserMiddleware::class]);
                Route::get('upcoming', [App\Http\Controllers\API\TicketsController::class, 'upcoming'])->middleware([AuthMandatoryMiddleware::class, UserMiddleware::class]);
            });

            Route::get('/purchase-history', [App\Http\Controllers\API\OrderController::class, 'purchaseHistory'])->middleware([AuthMandatoryMiddleware::class, UserMiddleware::class]);

            Route::post('/register', [App\Http\Controllers\API\AuthController::class, 'register']);
            Route::post('/login', [App\Http\Controllers\API\AuthController::class, 'login']);

            Route::post('forget-password', [App\Http\Controllers\API\UserController::class, 'forgetPassword'])->middleware([UserMiddleware::class]);
            Route::post('/reset-password', [App\Http\Controllers\API\UserController::class, 'resetPassword']);

            Route::post('/login/social', [App\Http\Controllers\API\AuthController::class, 'loginUsingProvider']);
            Route::post('/check', [App\Http\Controllers\API\AuthController::class, 'check']);
        });

        Route::prefix('otp')->group(function () {
            Route::post('/verify', [App\Http\Controllers\API\OTPController::class, 'verify']);
            Route::post('/send', [App\Http\Controllers\API\OTPController::class, 'send']);
        });
    });

    Route::get('/force-update/{platform}/{version}', function ($platform, $version) {

        switch ($platform) {
            case 'android':
                $value =  env('ANDROID_VERSION', "1.0.0") > $version;
                $link = env('ANDROID_LINK');

                break;
            case 'ios':
                $value =  env('IOS_VERSION', "1.0.0") > $version;
                $link = env('IOS_LINK');
                break;
            case 'pos':
                $value  = env('POS_VERSION', "1.0.0") > $version;
                //                $link = env('APP_URL').'/app/pos/v'.env('POS_VERSION').'/iraqi_cinema_pos_setup.exe';
                $link = env("POS_LINK");
                break;
            case 'kiosk':
                $value =  env('KIOSK_VERSION', "1.0.0") > $version;
                //                $link = env('APP_URL').'/app/kiosk/v'.env('KIOSK_VERSION').'/iraqi_cinema_kiosk_setup.exe';
                $link = env("KIOSK_LINK");
                break;
        }

        return [
            'status' => $value,
            'link' => $link
        ];

        //return false;

    })->whereIn('platform', ['android', 'ios', 'pos', 'kiosk']);

    Route::get("/splash", function () {
        return response()->json([
            'maintenance' => env('MAINTENANCE_MODE', "0"),
            'currency'=>'IQD'

        ], 200);
    });

    // Route::get('/notifications', [App\Http\Controllers\API\NotificationController::class, 'list']);

    Route::group(['prefix' => 'cart', 'middleware' => AuthMandatoryMiddleware::class], function () {

        Route::post('/create', [App\Http\Controllers\API\CartController::class, 'createCart']);
        Route::post('/expire', [App\Http\Controllers\API\CartController::class, 'expireCart']);

        Route::post('/empty', [App\Http\Controllers\API\CartController::class, 'emptyCart']);

        Route::get('/details', [App\Http\Controllers\API\CartController::class, 'details']);


        Route::post('/item/add', [App\Http\Controllers\API\CartController::class, 'addItemToCart']);
        Route::post('/item/remove', [App\Http\Controllers\API\CartController::class, 'removeItemFromCart']);

        Route::post('/seat/add', [App\Http\Controllers\API\CartController::class, 'addSeatsToCart']);
        Route::post('/seat/remove', [App\Http\Controllers\API\CartController::class, 'removeSeatFromCart']);

        Route::post('/imtiyaz/add', [App\Http\Controllers\API\CartController::class, 'addImtiyazToCart'])->middleware(POSUserMiddleware::class);
        Route::post('/imtiyaz/remove', [App\Http\Controllers\API\CartController::class, 'removeImtiyazFromCart'])->middleware(POSUserMiddleware::class);


        Route::post('/coupon/add', [App\Http\Controllers\API\CartController::class, 'addCouponToCart']);
        Route::post('/coupon/remove', [App\Http\Controllers\API\CartController::class, 'removeCouponFromCart']);


        Route::post('/reward/add', [App\Http\Controllers\API\CartController::class, 'addRewardToCart']);

        //ONLY for POS
        Route::post('/card-number/add', [App\Http\Controllers\API\CartController::class, 'addCardNumberToCart'])->middleware(POSUserMiddleware::class);
        Route::post('/card-number/remove', [App\Http\Controllers\API\CartController::class, 'removeCardNumberFromCart'])->middleware(POSUserMiddleware::class);

        //ONLY for POS
        Route::post('/topup/add', [App\Http\Controllers\API\CartController::class, 'addTopupToCart'])->middleware(POSUserMiddleware::class);
        Route::post('/topup/remove', [App\Http\Controllers\API\CartController::class, 'removeTopupFromCart'])->middleware(POSUserMiddleware::class);
    });

    Route::get('/payment-methods', [App\Http\Controllers\API\PaymentController::class, 'list'])->middleware(AuthMandatoryMiddleware::class);
    Route::get('/test', [App\Http\Controllers\API\CardController::class, 'test']);


    Route::group(['prefix' => 'order', 'middleware' => AuthOptionalMiddleware::class], function () {
        Route::post("/",  [\App\Http\Controllers\API\OrderController::class, 'get']);
        Route::post("/attempt",  [\App\Http\Controllers\API\OrderController::class, 'attempt']);
        Route::post("/refund",  [\App\Http\Controllers\API\OrderController::class, 'refund'])->middleware(POSUserMiddleware::class);
        Route::post("/print",  [\App\Http\Controllers\API\OrderController::class, 'print'])->middleware([POSUserMiddleware::class, AuthMandatoryMiddleware::class]);
        Route::get("/{order_id}/details",  [\App\Http\Controllers\API\OrderController::class, 'details']);
        Route::get("/reserved",  [\App\Http\Controllers\API\OrderController::class, 'getReservedTotal']);
        Route::get("/last-order",  [\App\Http\Controllers\API\OrderController::class, 'PosGetLastOrderInfoforCashier'])->middleware([POSUserMiddleware::class, AuthMandatoryMiddleware::class]);
    });

    Route::prefix('movies')->group(function () {
        Route::get('/{id}', [App\Http\Controllers\API\MovieController::class, 'show'])->middleware([AuthOptionalMiddleware::class]); //movie details
        Route::get('/', [App\Http\Controllers\API\MovieController::class, 'search']);
        Route::get('/favorites/list', [App\Http\Controllers\API\FavoriteController::class, 'list'])->middleware([AuthMandatoryMiddleware::class, UserMiddleware::class]);
        Route::post('movie/review', [App\Http\Controllers\API\ReviewController::class, 'review'])->middleware([AuthMandatoryMiddleware::class, UserMiddleware::class]);
        Route::post('/{movie_id}/favorites/toggle', [App\Http\Controllers\API\FavoriteController::class, 'toggle'])->middleware([AuthMandatoryMiddleware::class, UserMiddleware::class]);
    });

    Route::get('/movie-show/{movie_show_id}/theater-seats', [App\Http\Controllers\API\TheaterSeatsController::class, 'listSeats']);

    Route::prefix('branches')->group(function () {
        Route::get('/', [App\Http\Controllers\API\BranchController::class, 'list']);
        Route::get('/{branch_id}/active-movies', [App\Http\Controllers\API\BranchController::class, 'activeMovies']);
        Route::get('/{branch_id}/movies/{movie_id}/shows', [App\Http\Controllers\API\BranchController::class, 'moviesShows']); //shows of the movie
        Route::get('/{branch_id}/items', [App\Http\Controllers\API\POS\ConsessionsController::class, 'getItems']);
    });

    Route::group([
        'prefix' => 'content',
        'middleware' => [twa\cmsv2\Http\Middleware\LanguageMiddleware::class]
    ], function () {
        Route::get('/responses/{type}', [App\Http\Controllers\API\ContentController::class, 'responses']);

        Route::get('/slideshows', [App\Http\Controllers\API\ContentController::class, 'getSlideshows']);
        Route::get('/faqs', [App\Http\Controllers\API\ContentController::class, 'getFaqs']);
        Route::get('/page/{slug}', [App\Http\Controllers\API\ContentController::class, 'getPage']);
        Route::get('/settings', [App\Http\Controllers\API\ContentController::class, 'getSetting']);
    });

    Route::group(['prefix' => 'pos'], function () {

        Route::group([
            'prefix' => 'user',
            'middleware' => [AuthMandatoryMiddleware::class, POSUserMiddleware::class]
        ], function () {
            Route::post('create', [App\Http\Controllers\API\POS\CustomersController::class, 'createUser']);
            Route::post('check/phone', [App\Http\Controllers\API\POS\CustomersController::class, 'getPhone']);
            Route::post('edit', [App\Http\Controllers\API\POS\CustomersController::class, 'editUser']);
            Route::post('card/info', [App\Http\Controllers\API\CardController::class, 'getCardInfo']);
            Route::get('card/update', [App\Http\Controllers\API\CardController::class, 'updateUserCard']);
            Route::post('redeem-code', [App\Http\Controllers\API\RewardController::class, "posRedeemCode"]);
        });



        Route::post('/wallet-topup', [App\Http\Controllers\API\POS\WalletController::class, 'walletTopup'])->middleware(([AuthMandatoryMiddleware::class, POSUserMiddleware::class]));

        Route::post('/user', [App\Http\Controllers\API\POS\PosUserController::class, 'getUserFromAccessToken'])->middleware([AuthMandatoryMiddleware::class, POSUserMiddleware::class]);

        Route::post('/login', [App\Http\Controllers\API\POS\PosUserController::class, 'login']);
        Route::post('/logout', [App\Http\Controllers\API\POS\PosUserController::class, 'logout'])->middleware((AuthMandatoryMiddleware::class));

        //shiftSummary
        Route::get("/shift-summary", [App\Http\Controllers\API\POS\PosUserController::class, 'shiftSummary'])->middleware((AuthMandatoryMiddleware::class));

        Route::get('/branches/{branch_id}/movies/active-shows', [App\Http\Controllers\API\POS\MovieController::class, 'getBranchPosActiveMovieShows']);
    });

    Route::group(['prefix' => 'kiosk'], function () {
        Route::post('/login', [App\Http\Controllers\API\KIOSK\KioskUserController::class, 'login']);
    });
});
