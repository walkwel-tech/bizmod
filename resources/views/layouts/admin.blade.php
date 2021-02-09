<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Lakshay Dashboard') }}</title>
        <!-- Favicon -->
        <link href="{{ asset('argon') }}/img/brand/favicon.png" rel="icon" type="image/png">
        <!-- Icons -->
        <link href="{{ asset('argon') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet">
        <link href="{{ asset('argon') }}/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">

        @livewireStyles
        <!-- Argon CSS -->
        <link type="text/css" href="{{ mix('css/admin.css') }}" rel="stylesheet">

    </head>
    <body class="{{ $class ?? '' }}">
        @auth()
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            @include('layouts.navbars.sidebar')
        @endauth

        <div class="main-content">
            @include('layouts.navbars.navbar')
            @yield('content')
        </div>

        @guest()
            @include('layouts.footers.guest')
        @endguest

        <!-- Argon JS -->
        <script src="{{ mix('js/admin.js') }}"></script>
        @livewireScripts
        <script>
            var fetchStatesURL = "{{ route('locations.states') }}";
            var fetchCitiesURL = "{{ route('locations.cities') }}";

            var serverMessage = "{{ Session::get('success') ?? Session::get('status') }}";
            var serverWarning = "{{ Session::get('warning') ?? '' }}";

            let chartsToRender = [];
        </script>

        @stack('js')
    </body>
</html>
