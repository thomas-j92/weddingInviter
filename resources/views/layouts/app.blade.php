<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="api-base-url" content="{{ url('') }}" />

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link href="{{ asset('webfonts/fa-solid-900.woff2') }}" crossorigin rel="preload" as="font">
    <link href="{{ asset('webfonts/fa-regular-400.woff2') }}" crossorigin rel="preload" as="font">
    <link href="{{ asset('webfonts/fa-brands-400.woff2') }}" crossorigin rel="preload" as="font">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <main>
            @include('inc.nav')

            @yield('content')
        </main>
    </div>
</body>
</html>
