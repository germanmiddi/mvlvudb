<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-white">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Favicons -->
        <link rel="icon" type="image/x-icon" href="/favicon/favicon.ico">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
        <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="192x192" href="/favicon/android-chrome-192x192.png">
        <link rel="icon" type="image/png" sizes="512x512" href="/favicon/android-chrome-512x512.png">
        <link rel="manifest" href="/favicon/site.webmanifest">
        <meta name="theme-color" content="#ffffff">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-config" content="/favicon/browserconfig.xml">

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <!-- Google Maps -->
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC2ZgKApfK_YBbSnZE6NGGacXCnYqF3zNw&libraries=places,visualization"></script>

        <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/v-mask/dist/v-mask.min.js"></script>

        <!-- Scripts -->
        @routes
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased h-full">
        @inertia

        <!-- @env ('local')
            <script src="http://localhost:3000/browser-sync/browser-sync-client.js"></script>
        @endenv -->
    </body>
</html>
