<?php

namespace App\Helpers;

use Illuminate\Support\Facades\URL;

class UrlHelper
{
    /**
     * Force HTTPS for all URLs
     */
    public static function forceHttps()
    {
        if (config('app.env') === 'production' || config('app.force_https')) {
            URL::forceScheme('https');
            URL::forceRootUrl(config('app.url'));
        }
    }

    /**
     * Generate URL with forced HTTPS
     */
    public static function secureUrl($path = '', $parameters = [])
    {
        self::forceHttps();
        return URL::to($path, $parameters);
    }
}
