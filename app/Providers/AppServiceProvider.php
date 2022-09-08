<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
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
        Model::preventLazyLoading(!$this->app->isProduction());
        if ($this->app->environment('production')) {
            // URL::forceScheme('https'); // gausah pake .htaccess lgi buat setting https itu udah di force sama si URL ?itu nanti buat di cpanel
        }
        Response::macro('message', function ($success, $data) {
            return Response::json([
                'success'  => $success,
                'message' => $data,
            ]);
        });

        JsonResource::withoutWrapping();
    }
}
