<?php

use App\Http\Controllers\Backsite\UserController;
use App\Http\Controllers\Backsite\UserTypeController;
use App\Http\Controllers\Frontsite\AppointmentController;
use App\Http\Controllers\Frontsite\LandingController;
use App\Http\Controllers\Frontsite\PaymentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Frontsite Routes 
Route::get('/', [LandingController::class, 'index']);
Route::view('/register-success', 'pages.frontsite.success.register-success');

Route::middleware(['auth'])->group(function () {
    Route::get('/appointment/{id}', [AppointmentController::class, 'index'])->name('appointment');
    Route::get('/payment', [PaymentController::class, 'index']);
    Route::view('/payment-success', 'pages.frontsite.success.payment-success');
});
// End Frontsite Routes

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Backsite Routes
    Route::prefix('backsite')->name('backsite.')->middleware(['auth'])->group(function () {
        Route::prefix('management-access')->group(function () {
            Route::resource('user-type', UserTypeController::class)->only(['index']);
            Route::resource('user', UserController::class);
        });
    });
    // End Backsite Routes
});
