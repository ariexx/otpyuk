<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191); //for mariadb - utf84MB
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');
        Paginator::useBootstrapFour();
        Model::preventLazyLoading(!$this->app->isProduction()); //kenapa kgk keload, ini buat n+1 klo query lu double bakal muncul warn ini telescope buat ? debug ?lu tau laravel deubg bar ga
        if ($this->app->environment('production')) {
            // URL::forceScheme('https'); // gausah pake .htaccess lgi buat setting https itu udah di force sama si URL ?itu nanti buat di cpanel
        }
        Response::macro('message', function ($success, $data) {
            return Response::json([
                'success'  => $success,
                'message' => $data,
            ]);
        });
    }
}
