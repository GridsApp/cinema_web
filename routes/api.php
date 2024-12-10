<?php

use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\LanguageMiddleware;
use App\Http\Middleware\UserMiddleware;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'v1', 'middleware' => LanguageMiddleware::class], function () {
    Route::prefix('auth')->group(function () {
        Route::prefix('user')->group(function () {
            Route::get('/account', [App\Http\Controllers\API\UserController::class, 'getAccount'])->middleware(AuthMiddleware::class);
            Route::post('/change-password', [App\Http\Controllers\API\UserController::class, 'changePassword'])->middleware(AuthMiddleware::class);
            Route::post('/delete-account', [App\Http\Controllers\API\UserController::class, 'deleteAccount'])->middleware(AuthMiddleware::class);
            Route::post('/wallet/recharge', [App\Http\Controllers\API\WalletController::class, 'recharge'])->middleware(AuthMiddleware::class);

            Route::post('/test', [App\Http\Controllers\API\WalletController::class, 'test'])->middleware(AuthMiddleware::class);
            Route::get('/rewards', [App\Http\Controllers\API\RewardController::class, 'list'])->middleware(AuthMiddleware::class);
            Route::post('{reward_id}/rewards/redeem', [App\Http\Controllers\API\RewardController::class, 'redeem'])->middleware(AuthMiddleware::class);

            Route::post('/register', [App\Http\Controllers\API\AuthController::class, 'register']);
            Route::post('/login', [App\Http\Controllers\API\AuthController::class, 'login']);
            Route::post('/check', [App\Http\Controllers\API\AuthController::class, 'check']);
        });

        Route::prefix('otp')->group(function () {
            Route::post('/verify', [App\Http\Controllers\API\OTPController::class, 'verify']);
            Route::post('/send', [App\Http\Controllers\API\OTPController::class, 'send']);
        });
    });

    Route::get('/movie-show/{movie_show_id}/theater-seats', [App\Http\Controllers\API\TheaterSeatsController::class, 'listSeats']);

    Route::group(['prefix' => 'cart', 'middleware' => AuthMiddleware::class], function () {
        Route::post('/create', [App\Http\Controllers\API\CartController::class, 'createCart']);
        Route::post('/expire', [App\Http\Controllers\API\CartController::class, 'expireCart']);
        Route::post('/item/add', [App\Http\Controllers\API\CartController::class, 'addItemCart']);
        Route::post('/item/remove', [App\Http\Controllers\API\CartController::class, 'removeItemFromCart']);
        Route::post('/seat/add', [App\Http\Controllers\API\CartController::class, 'addSeatsCart']);
        Route::post('/seat/remove', [App\Http\Controllers\API\CartController::class, 'removeSeatFromCart']);
        Route::post('/coupon/add', [App\Http\Controllers\API\CartController::class, 'addCoupnTocart']);
        Route::post('/coupon/remove', [App\Http\Controllers\API\CartController::class, 'removeCouponFromCart']);
        Route::post('/card-number/add', [App\Http\Controllers\API\CartController::class, 'addCardNumberTocart']);
        Route::post('/card-number/remove', [App\Http\Controllers\API\CartController::class, 'removeCardNumberFromcart']);
       
        
        Route::post('/topup/add', [App\Http\Controllers\API\CartController::class, 'addTopupToCart']);
        Route::post('/topup/remove', [App\Http\Controllers\API\CartController::class, 'removeTopupFromCart']);

        Route::get('/list', [App\Http\Controllers\API\CartController::class, 'list']);
    });


    Route::post("/order",  [\App\Http\Controllers\API\OrderController::class, 'get'])->middleware(UserMiddleware::class);
    Route::post("/order/attempt",  [\App\Http\Controllers\API\OrderController::class, 'attempt'])->middleware(UserMiddleware::class);
    Route::post("/order/refund",  [\App\Http\Controllers\API\OrderController::class, 'refund'])->middleware(UserMiddleware::class);
    Route::get('/list/items', [App\Http\Controllers\API\POS\ConsessionsController::class, 'getItems']);



    Route::prefix('movies')->group(function () {
        Route::get('/{id}', [App\Http\Controllers\API\MovieController::class, 'show'])->middleware(UserMiddleware::class);
        Route::get('/', [App\Http\Controllers\API\MovieController::class, 'search']);
        Route::get('/favorites/list', [App\Http\Controllers\API\FavoriteController::class, 'list'])->middleware(AuthMiddleware::class);
        Route::post('/{movie_id}/favorites/toggle', [App\Http\Controllers\API\FavoriteController::class, 'toggle'])->middleware(AuthMiddleware::class);
    });

    Route::prefix('branches')->group(function () {
        Route::get('/', [App\Http\Controllers\API\BranchController::class, 'list']);
        Route::get('/{branch_id}/active-movies', [App\Http\Controllers\API\BranchController::class, 'activeMovies']);
        Route::get('/{branch_id}/movies/{movie_id}/shows', [App\Http\Controllers\API\BranchController::class, 'moviesShows']);
    });

    Route::group([
        'prefix' => 'content',
        'middleware' => [App\Http\Middleware\LanguageMiddleware::class]
    ], function () {
        Route::get('/responses/{type}', [App\Http\Controllers\API\ContentController::class, 'responses']);

        Route::get('/slideshows', [App\Http\Controllers\API\ContentController::class, 'getSlideshows']);
        Route::get('/faqs', [App\Http\Controllers\API\ContentController::class, 'getFaqs']);
        Route::get('/page/{slug}', [App\Http\Controllers\API\ContentController::class, 'getPage']);
        Route::get('/settings', [App\Http\Controllers\API\ContentController::class, 'getSetting']);
    });

    Route::group(['prefix' => 'pos'], function () {
        Route::post('/create', [App\Http\Controllers\API\POS\CustomersController::class, 'CreateUser']);
        Route::post('/check/phone', [App\Http\Controllers\API\POS\CustomersController::class, 'getPhone']);
        Route::post('/edit', [App\Http\Controllers\API\POS\CustomersController::class, 'editUser']);
        Route::post('/card/info', [App\Http\Controllers\API\CardController::class, 'getCardInfo']);
        Route::get('/card/update', [App\Http\Controllers\API\CardController::class, 'updateUserCard']);
        Route::post('/login', [App\Http\Controllers\API\POS\PosUserController::class, 'login']);
        Route::get('/branches/{branch_id}/movies/active-shows', [App\Http\Controllers\API\POS\MovieController::class, 'getBranchPosActiveMovieShows']);
      
    });
});
