<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class ForceHttps
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Force HTTPS in production
        if (config('app.env') === 'production' || config('app.force_https')) {
            // Forzar HTTPS en la request actual
            $request->server->set('HTTPS', 'on');
            $request->server->set('SERVER_PORT', 443);

            // Forzar scheme y URL base
            URL::forceScheme('https');
            URL::forceRootUrl(config('app.url'));

            // Log para debug
            \Log::info('ForceHttps middleware executed', [
                'app_env' => config('app.env'),
                'force_https' => config('app.force_https'),
                'app_url' => config('app.url'),
                'current_url' => $request->url(),
                'scheme' => $request->getScheme(),
                'https_server' => $request->server->get('HTTPS'),
                'server_port' => $request->server->get('SERVER_PORT')
            ]);
        }

        return $next($request);
    }
}
