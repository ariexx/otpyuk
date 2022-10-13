<?php

use App\Http\Livewire\Auth\Login;
use App\Settings\GeneralSettings;
use App\Http\Livewire\Auth\Register;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HistoryOrderController;
use App\Http\Controllers\Push\ServiceController;

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
    if (Auth::check()) {
        return redirect()->route('home');
    } else {
        return redirect()->route('login');
    }
});

Route::get('daftar-harga', function () {
    if (Cache::has('services')) {
        $services = Cache::get('services');
    } else {
        $services = \App\Models\Service::where('is_active', 1)->get();
        Cache::remember('services', now()->addDay(), function () use ($services) {
            return $services;
        });
    }
    return view('prices.index', compact('services'));
})->name('prices.index');

Auth::routes(['login' => false, 'register' => false, 'verify' => true]);

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
    Route::get('get-services', [ServiceController::class, 'index']);
    Route::get('rate-update', [ServiceController::class, 'rateUpdate']);
    Route::get('update-status', function () {
        //call the command to update status
        return Artisan::call('order:check');
    });
    Route::get('clear-cache', function () {
        //call the command to update status
        Artisan::call('cache:clear');
        return abort(404);
    });
});

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth', 'verified');
