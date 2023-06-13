<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-white">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <!-- Google Maps -->
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC2ZgKApfK_YBbSnZE6NGGacXCnYqF3zNw&libraries=places"></script>

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
