<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;


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
        Blade::directive('convert', function ($money) {
            return "<?php echo number_format($money, 2 , ',', '.'); ?>";
        });
        Blade::directive('today', function ($money) {
            return "<?php echo date('d-m-Y H:i:s'); ?>";
        });

        date_default_timezone_set('America/Argentina/Buenos_Aires');
        Schema::defaultStringLength(191);

        if(env('APP_ENV') == 'production'){
            $this->app['request']->server->set('HTTPS', true);
        }
    }
}
