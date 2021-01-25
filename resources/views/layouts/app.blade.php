<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Lakshay Dashboard') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>

<body class="{{ $class ?? '' }}">
    <div id="app">
        @if($navbar ?? false)
        @include('layouts.navbars.navbar-frontend')
        @endif

        @yield('content')

        @if($footer ?? false)
        <footer class="container_brand">
            <p class="copyright">
                <span>@Copyright {{ config('app.name', 'Walkwel') . ' ' . date('Y') }}</span>
            </p>
        </footer>
        @endif
    </div>

    @stack('js')
</body>

</html>
