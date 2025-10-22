<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class HttpsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Force HTTPS in production or when FORCE_HTTPS is enabled
        if (config('app.force_https') || config('app.env') === 'production') {
            URL::forceScheme('https');
            URL::forceRootUrl(config('app.url'));

            // Log para debug
            \Log::info('HttpsServiceProvider boot executed', [
                'app_env' => config('app.env'),
                'force_https' => config('app.force_https'),
                'app_url' => config('app.url')
            ]);
        }
    }
}
