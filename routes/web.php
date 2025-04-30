<?php

use App\Http\Controllers\BranchItemsController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\ManageBookingController;
use App\Http\Controllers\ManageWalletController;
use App\Http\Controllers\MigrationsController;
use App\Http\Controllers\PriceGroupZonesController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\WeekController;
use App\Livewire\Website\ForgotPasswordForm;
use App\Livewire\Website\OtpVerificationForm;
use App\Models\PaymentAttemptLog;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Process;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;




Route::group([
  'prefix' => '/migrations',

], function () {
  Route::get('/pos-users', [MigrationsController::class, 'theaters']);
});






Route::get('/survey/{order_id}/{user_id}/{token}', [App\Http\Controllers\SurveyController::class, 'showSurvey'])
  ->name('survey-link');

Route::post('/survey', [App\Http\Controllers\SurveyController::class, 'submitSurvey']);



Route::view('/app/update/google', 'pages.update-google');

Route::prefix('payment')->group(function () {
  Route::get('/initialize/{payment_attempt_id}', [App\Http\Controllers\API\PaymentController::class, 'initialize'])->name('payment.initialize');
  Route::get('/response/{payment_attempt_id}', [App\Http\Controllers\API\PaymentController::class, 'omniResponse'])->name('payment.response');

  Route::get('/response', function () {
    echo "";
  })->name('payment.response.status');


  Route::get('/callback/{payment_attempt_id}', [App\Http\Controllers\API\PaymentController::class, 'callback'])->name('payment.callback');
  // Route::get('/response', function () {
  //   echo request()->input('type');
  // })->name('payment.response');
});

Route::get("hyperpay/redirect/{provider_key}/{log_id}/{attempt_id}/{token}", function ($provider_key, $log_id, $attempt_id, $token) {

  $log =  \App\Models\PaymentAttemptLog::find($log_id);


  if (!$log) {
    return abort("403", "Token Missmatch");
  }


  $payload = $log->payload ?? null;



  if ($token != md5(($payload["id"] ?? '') . $attempt_id . $provider_key . ($payload["integrity"] ?? ''))) {
    return abort("403", "Token Missmatch");
  }

  return view('payment.hyperpay.redirect', [
    'provider_key' => $provider_key,
    'attempt_id' => $attempt_id,
    'integrity' => $payload["integrity"],
    'checkout_id' => $payload["id"]
  ]);
})->name('hyperpay-redirect-link');

Route::get('/set/language/{lang}', function ($lang) {
  session(['locale' => $lang]);
  app()->setlocale($lang);

  $uri = URL::previous();

  $uri = explode('/', $uri);

  $uri[4] = $lang;
  $url = implode('/', $uri);

  return redirect($url);
})->name('language-switcher');
Route::middleware(\App\Http\Middleware\CinemaDefaultMiddleware::class)->get('/', function () {});

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
    Route::post('/profile/add-image', [\App\Http\Controllers\WEBSITE\UserController::class, 'addImage'])->name('addImage');
    Route::get('/profile/add-image', [\App\Http\Controllers\WEBSITE\UserController::class, 'render'])->name('render');

    Route::get('/profile/update', [\App\Http\Controllers\WEBSITE\UserController::class, 'update'])->name('update');
    Route::get('/profile/delete', [\App\Http\Controllers\WEBSITE\UserController::class, 'renderDelete'])->name('renderDelete');
    Route::post('/profile/delete', [\App\Http\Controllers\WEBSITE\UserController::class, 'deleteAccount'])->name('deleteAccount');
    Route::get('/profile/favorites', [\App\Http\Controllers\WEBSITE\UserController::class, 'favorites'])->name('favorites');
    Route::get('/profile/wallet-transactions', [\App\Http\Controllers\WEBSITE\UserController::class, 'getWalletTransactions'])->name('getWalletTransactions');
    Route::get('/loyality-card', [\App\Http\Controllers\WEBSITE\UserController::class, "getLoyaltyCard"])->name('getLoyaltyCard');
    Route::get('/purchase-history', [\App\Http\Controllers\WEBSITE\UserController::class, "purchaseHistory"])->name('purchaseHistory');
    Route::get('/profile/logout', [\App\Http\Controllers\WEBSITE\UserController::class, "logout"])->name('logout-web');
  });





  Route::group([
    'prefix' => '/checkout',
    'middleware' => [\App\Http\Middleware\CheckCartExpiration::class]

  ], function () {
    // Route::post('/seat/selection', [\App\Http\Controllers\WEBSITE\CartController::class, 'createCart'])->name('checkout');

    Route::post('/seat/selection', [\App\Http\Controllers\WEBSITE\OrderController::class, 'getTheaterSeats'])->name('getTheaterSeats');
    Route::get('/item/selection', [\App\Http\Controllers\WEBSITE\OrderController::class, 'getItems'])->name('getItems');
  });
});
Route::post('/cart/add-seats', [\App\Http\Controllers\WEBSITE\CartController::class, 'addSeatsToCart']);

Route::group(['prefix' => 'cms', 'middleware' => \twa\cmsv2\Http\Middleware\CmsAuthMiddleware::class], function () {
  Route::get("/manage/bookings", [ManageBookingController::class, 'render'])->name('manage-bookings');
  Route::get("/manage/wallets", [ManageWalletController::class, 'render'])->name('manage-wallets');

  Route::get("/items/list", [ItemsController::class, 'render'])->name('items');
  Route::get('/items/family/create', [ItemsController::class, 'createItem'])->name('items.create');
  Route::get('/items/edit/{family_group_id}', [ItemsController::class, 'editItem'])->name('item.edit');

  Route::get("/price-groups/{id}/zones", [PriceGroupZonesController::class, 'render'])->name('price-group-zones');
  Route::get("/price-groups/{id}/zones/create", [PriceGroupZonesController::class, 'createZone'])->name('price-group-zones.create');
  Route::get("/price-groups/{id}/zones/{zone_id}/update", [PriceGroupZonesController::class, 'editZone'])->name('price-group-zones.update');



  Route::get("/branches/{id}/items/{item_id}/update", [BranchItemsController::class, 'editItem'])->name('items.edit');
  Route::get("/branches/{id}/items/create", [BranchItemsController::class, 'createItem'])->name('branch-item.create');
  Route::get("/branches/{id}/items", [BranchItemsController::class, 'render'])->name('branch-items');


  Route::group(['prefix' => 'distributor'], function () {

    Route::get('/box-office-report', [\App\Http\Controllers\BoxOfficeReportController::class, 'render'])->name('box-office-report.render');
    Route::get('/box-office-report/result', [\App\Http\Controllers\BoxOfficeReportController::class, 'result'])->name('box-office-report.render-result');

    Route::get('/box-office-summary', [\App\Http\Controllers\BoxOfficeReportController::class, 'renderSummary'])->name('box-office-summary.render');
    Route::get('/box-office-report-summary/result', [\App\Http\Controllers\BoxOfficeReportController::class, 'renderSummaryResult'])->name('box-office-report-summary.render-result');


    Route::get('/distributor-film-hire', [\App\Http\Controllers\DistributorSharesController::class, 'render'])->name('distributor-film-hire.render');
    Route::get('/distributor-film-hire/result', [\App\Http\Controllers\DistributorSharesController::class, 'result'])->name('distributor-film-hire.render-result');
  });
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



Route::get("/get/week/range/{date}", [WeekController::class, 'getWeekRange']);
