<?php

use App\Http\Controllers\ManageBookingController;
use App\Http\Controllers\ManageWalletController;
use Illuminate\Support\Facades\Route;


Route::prefix('payment')->group(function () {
  Route::get('/initialize/{payment_attempt_id}', [App\Http\Controllers\API\PaymentController::class, 'initialize'])->name('payment.initialize');
  Route::get('/callback/{payment_attempt_id}', [App\Http\Controllers\API\PaymentController::class, 'callback'])->name('payment.callback');
  Route::get('/response', function () {
    echo request()->input('type');
  })->name('payment.response');
});

Route::get('/', [\App\Http\Controllers\WEBSITE\HomePageController::class, 'home'])->name('home');
Route::get('/movies/listing', [\App\Http\Controllers\WEBSITE\MovieController::class, 'listing'])->name('listing');
Route::get('/about-us', [\App\Http\Controllers\WEBSITE\AboutController::class, 'about'])->name('about');
// Route::get('/contact-us', [\App\Http\Controllers\WEBSITE\AboutController::class, 'about'])->name('about');
Route::get('/contact-us', [App\Http\Controllers\WEBSITE\ContactController::class, 'contact']);

Route::get('/movie-details/{slug}', [App\Http\Controllers\WEBSITE\MovieController::class, 'details'])->name('movie-details');

Route::get('branches/listing', [\App\Http\Controllers\WEBSITE\BranchController::class, 'listing'])->name('listing');

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
