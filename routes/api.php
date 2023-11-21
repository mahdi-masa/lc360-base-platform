<?php

use Laravel\Sanctum\Http\Controllers\CsrfCookieController;
use App\Http\Controllers\User\AuthController as UserAuthController;
use App\Http\Controllers\User\PlantController;
use App\Enum\DonationTypeEnum;
use App\Http\Controllers\Donate\DonationController;
use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\UtilsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::prefix('v1')->group(function () {

    Route::controller(UtilsController::class)->name('utils.')->group(function () {
        Route::get('provinces', 'getProvinces')->name('provinces');
        Route::get('provinces/{province}/cities', 'getProvinceCities')->whereNumber('province')->name('province_cities')->scopeBindings();
    });

    Route::controller(UserController::class)->middleware(['auth:users'])->prefix('/me')->name('me.')->group(function () {
            Route::post('profile', 'profile')->name('profile');
    });

    Route::controller(UserAuthController::class)->prefix('/auth')->name('auth.')->group(function () {
        Route::post('phone-exists', 'phoneExistence')->name('phone_exists');
        Route::post('register', 'register')->name('register');
        Route::post('send-code', 'sendCode')->name('send_code');
        Route::post('verify-code', 'verifyCode')->name('verify_code');
        Route::get('csrf-cookie', [CsrfCookieController::class, 'show'])->name('csrf');
        Route::middleware('auth:users')->group(function () {
            Route::get('user', 'user')->name('user');
            Route::post('logout', 'logout')->name('logout');
        });
    });

    Route::controller(PlantController::class)->middleware(['auth:users'])->prefix('/plants')->name('plants.')->group(function () {
        Route::post('/', 'store')->name('store');
    });


    Route::controller(PlantController::class)->middleware(['auth:users'])->prefix('/plants')->name('plants.')->group(function () {
        Route::post('/', 'store')->name('store');
    });

    Route::controller(DonationController::class)->prefix('/payments')->name('payment.')->group(function () {
        Route::post('/donate/{type}', 'donate')->where('type', implode('|', DonationTypeEnum::cases()))->name('donate');
                
    });

    Route::controller(PaymentController::class)->prefix('/payments')->name('payment.')->group(function () {
        Route::post('/payment\{type}/verify', 'paymentVerification')->name('donate');
                
    });

   
});
