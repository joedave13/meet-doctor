<?php

use App\Http\Controllers\Backsite\AppointmentController as BacksiteAppointmentController;
use App\Http\Controllers\Backsite\ConsultationController;
use App\Http\Controllers\Backsite\DashboardController;
use App\Http\Controllers\Backsite\DoctorController;
use App\Http\Controllers\Backsite\PatientController;
use App\Http\Controllers\Backsite\PaymentController as BacksitePaymentController;
use App\Http\Controllers\Backsite\PermissionController;
use App\Http\Controllers\Backsite\RoleController;
use App\Http\Controllers\Backsite\SpecialistController;
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
    Route::get('/appointment/{doctor}', [AppointmentController::class, 'index'])->name('appointment');
    Route::post('/appointment', [AppointmentController::class, 'store'])->name('appointment.store');

    Route::get('/payment/{appointment}', [PaymentController::class, 'index'])->name('payment');
    Route::post('/payment/{appointment}', [PaymentController::class, 'store'])->name('payment.store');
    Route::view('/payment-success', 'pages.frontsite.success.payment-success')->name('payment.success');
});
// End Frontsite Routes

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Backsite Routes
    Route::prefix('backsite')->name('backsite.')->middleware(['auth'])->group(function () {
        Route::prefix('management-access')->group(function () {
            Route::resource('user-type', UserTypeController::class)->only(['index']);
            Route::resource('user', UserController::class);
            Route::resource('permission', PermissionController::class)->only(['index']);
            Route::resource('role', RoleController::class)->except(['show']);
        });

        Route::prefix('master-data')->group(function () {
            Route::resource('specialist', SpecialistController::class)->except(['show']);
            Route::resource('consultation', ConsultationController::class)->except(['show']);
        });

        Route::prefix('operational')->group(function () {
            Route::resource('doctor', DoctorController::class);
            Route::resource('patient', PatientController::class)->only(['index', 'show']);
            Route::resource('appointment', BacksiteAppointmentController::class)->only(['index', 'show']);
            Route::resource('payment', BacksitePaymentController::class)->only(['index', 'show']);
        });
    });
    // End Backsite Routes
});
