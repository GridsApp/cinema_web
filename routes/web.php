<?php

use App\Http\Controllers\ManageBookingController;
use App\Http\Controllers\ManageWalletController;
use App\Livewire\Website\ForgotPasswordForm;
use App\Livewire\Website\OtpVerificationForm;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

Route::prefix('payment')->group(function () {
  Route::get('/initialize/{payment_attempt_id}', [App\Http\Controllers\API\PaymentController::class, 'initialize'])->name('payment.initialize');
  Route::get('/callback/{payment_attempt_id}', [App\Http\Controllers\API\PaymentController::class, 'callback'])->name('payment.callback');
  Route::get('/response', function () {
    echo request()->input('type');
  })->name('payment.response');
});

Route::get('/set/language/{lang}', function ($lang) {
  session(['locale' => $lang]);
  app()->setlocale($lang);

  $uri = URL::previous();

  $uri = explode('/', $uri);

  $uri[4] = $lang;
  $url = implode('/', $uri);

  return redirect($url);
})->name('language-switcher');
// Route::middleware(\App\Http\Middleware\CinemaDefaultMiddleware::class)->get('/', function () {   });

Route::group([
  'prefix'     => '/{cinema_prefix}/{language_prefix}/',
  'middleware' => [\App\Http\Middleware\CinemaDefaultDataMiddleware::class, \App\Http\Middleware\Language::class],
], function () {


  Route::get('/', [\App\Http\Controllers\WEBSITE\HomePageController::class, 'home'])->name('home');
  Route::get('/about-us', [\App\Http\Controllers\WEBSITE\AboutController::class, 'about'])->name('about');
  Route::get('/contact-us', [App\Http\Controllers\WEBSITE\ContactController::class, 'contact'])->name('contact');
  Route::get('/movies/listing', [\App\Http\Controllers\WEBSITE\MovieController::class, 'listing'])->name('movie-listing');


  Route::get('/movie-details/{slug}', [\App\Http\Controllers\WEBSITE\MovieController::class, 'details'])->name('details');


  Route::get('branches/listing', [\App\Http\Controllers\WEBSITE\BranchController::class, 'listing'])->name('listing');
  Route::get('/sign-in', function () {
    return view('website.pages.auth.sign-in');
  })->name('login-web');
  Route::get('/register', function () {
    return view('website.pages.auth.register');
  })->name('register-web');
  Route::get('/forgot-password', [\App\Http\Controllers\WEBSITE\ForgotPasswordController::class, 'render'])->name('forgot-password');
  Route::get('/otp-verify', [\App\Http\Controllers\WEBSITE\OtpVerificationController::class, 'render'])->name('otp-verify');
  Route::get('/password-reset', [\App\Http\Controllers\WEBSITE\ForgotPasswordController::class, 'showResetForm'])->name('password-reset');


  // Route::get('/forgot-password', ForgotPasswordForm::class)->name('forgot-password');
  // Route::get('/verify-otp', OtpVerificationForm::class)->name('verify-otp');



  Route::get('/movie-details/{slug}', [\App\Http\Controllers\WEBSITE\MovieController::class, 'details'])->name('details');


  Route::group([
    'prefix' => '/account',
    'middleware' => [\App\Http\Middleware\CheckWebsiteAuth::class],
  ], function () {
    Route::get('/flush-session', function () {
      session()->flush();
      return "Session has been flushed.";
    });
    Route::get('/profile/update', [\App\Http\Controllers\WEBSITE\UserController::class, 'update'])->name('update');
    Route::get('/profile/favorites', [\App\Http\Controllers\WEBSITE\UserController::class, 'favorites'])->name('favorites');
    Route::get('/profile/wallet-transactions', [\App\Http\Controllers\WEBSITE\UserController::class, 'getWalletTransactions'])->name('getWalletTransactions');
    Route::get('/loyality-card', [\App\Http\Controllers\WEBSITE\UserController::class, "getLoyaltyCard"])->name('getLoyaltyCard');
    Route::get('/purchase-history', [\App\Http\Controllers\WEBSITE\UserController::class, "purchaseHistory"])->name('purchaseHistory');
    Route::get('/profile/logout', [\App\Http\Controllers\WEBSITE\UserController::class, "logout"])->name('logout-web');
    // Route::get('/profile', function () {
    //   $profile = (new \App\Http\Controllers\API\UserController())->getProfile(request()->get('user'));
    //   return view('website.profile.profile', compact('profile'));
    // });
    // Route::get('/logout', [\App\Http\Controllers\WebsiteGeneralFunctionsController::class, 'logout'])->name('logout');
    // Route::post('/password/post', [\App\Http\Controllers\WebsiteGeneralFunctionsController::class, 'updatePassword'])->name('update-pass-post');
    // Route::get('/my-favorites', [\App\Http\Controllers\WebsiteGeneralFunctionsController::class, "getFavorites"]);
    // Route::get('/loyality-card', [\App\Http\Controllers\WebsiteGeneralFunctionsController::class, "getLoyaltyCard"]);
    // Route::get('/recharge-wallet', [\App\Http\Controllers\WebsiteGeneralFunctionsController::class, "rechargeWalletGet"]);
    // Route::post('/recharge-wallet/post', [\App\Http\Controllers\WebsiteGeneralFunctionsController::class, "rechargeWalletPost"]);
    // Route::post('/movie/fav/submit', [\App\Http\Controllers\WebsiteGeneralFunctionsController::class, "addToFav"]);
    // Route::post('/picture/update', [\App\Http\Controllers\WebsiteGeneralFunctionsController::class, "updateProfileImage"]);
    // Route::get('/loyality-card/rewards', [\App\Http\Controllers\WebsiteGeneralFunctionsController::class, 'getLoyaltyRewards']);
    // Route::post('/loyality-card/rewards/redeem', [\App\Http\Controllers\WebsiteGeneralFunctionsController::class, 'redeemReward']);
    // Route::get('/wallet-transactions', [\App\Http\Controllers\WebsiteGeneralFunctionsController::class, "getWalletTransactionHistory"]);
    // Route::get('/purchase-history', [\App\Http\Controllers\WebsiteGeneralFunctionsController::class, "getPurchaseHistory"]);
  });
});

Route::group(['prefix' => 'cms', 'middleware' => \twa\cmsv2\Http\Middleware\CmsAuthMiddleware::class], function () {
  Route::get("/manage/bookings", [ManageBookingController::class, 'render'])->name('manage-bookings');
  Route::get("/manage/wallets", [ManageWalletController::class, 'render'])->name('manage-wallets');
});
Route::get('reports/reports/reports', function () {

  $report = (new \App\Reports\DailyAdmitsReport());

  $columns = $report->columns;

  $data = [
    'id' => 1,
    'label' => "hovig"
  ];

  $report->setRow($data);

  dd($report->rows);
});
