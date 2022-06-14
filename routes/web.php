<?php

use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Auth\Register;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HistoryOrderController;
use App\Http\Controllers\Push\ServiceController;
use App\Settings\GeneralSettings;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['login' => false, 'register' => false, 'verify' => true]);

Route::get('test', function (GeneralSettings $setting) {
    echo $setting->site_name;
});

Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
});

Route::middleware('auth', 'verified')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/history-order', [HistoryOrderController::class, 'index'])->name('history-order'); // ini kah ?
});

//route push
Route::prefix('push')->group(function () {
    Route::get('/testapi', [ServiceController::class, 'index']);
    Route::get('/rate-update', [ServiceController::class, 'rateUpdate']);
});

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth', 'verified');
