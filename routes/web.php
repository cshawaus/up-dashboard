<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SetupController;

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
    ->middleware(['auth', 'verified'])
    ->group(function () {
        Route::get('/', [DashboardController::class, 'overview'])->name('overview');
    });

/*
|--------------------------------------------------------------------------
| Account Setup
|--------------------------------------------------------------------------
*/

// ...

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
