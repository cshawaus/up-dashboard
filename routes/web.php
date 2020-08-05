<?php

use App\Http\Controllers\Dashboard\AccountController;
use App\Http\Controllers\Dashboard\OverviewController;
use App\Http\Controllers\SetupController;
use App\Http\Controllers\UpYeahTokenController;

use Illuminate\Support\Facades\Auth;
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

Auth::routes([
    'confirm'  => false,
    'login'    => true,
    'logout'   => true,
    'register' => false,
    'reset'    => false,
    'verify'   => false,
]);

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::name('dashboard.')
    ->middleware(['up.yeah.token', 'auth', 'verified'])
    ->group(function () {
        Route::get('/', [OverviewController::class, 'index'])->name('overview');

        Route::get('/account/{account}', [AccountController::class, 'index'])->name('account');
    });

/*
|--------------------------------------------------------------------------
| Account Setup
|--------------------------------------------------------------------------
*/

Route::name('user.')
    ->middleware(['auth', 'verified', 'permission:assign token'])
    ->group(function () {
        Route::get('set-token', [UpYeahTokenController::class, 'index'])->name('set-token');
        Route::post('set-token', [UpYeahTokenController::class, 'finish'])->name('set-token-finish');
    });

/*
|--------------------------------------------------------------------------
| Dashboard Setup
|--------------------------------------------------------------------------
*/

Route::name('setup.')
    ->prefix('setup')
    ->group(function () {
        Route::get('/', [SetupController::class, 'index'])->name('index');
        Route::post('/', [SetupController::class, 'finish'])->name('finish');
    });
