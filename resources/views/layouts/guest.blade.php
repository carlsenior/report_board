<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ isset($title) ? $title : config('app.name', 'AdminLTE 3')  }}</title>

        <link rel="icon" href="{{ url('favicon.ico') }}">

        <!-- Fonts -->
        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet"
              href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}">
        <!-- icheck bootstrap -->
        <link rel="stylesheet" href="{{ asset('css/icheck-bootstrap.min.css') }}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">

        @vite(['resources/css/app.css'])

    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="/" wire:navigate>{{ config('app.name', 'Ooops!') }}</a>
            </div>

            <div class="card">
                {{ $slot }}
            </div>
        </div>
        @vite('resources/js/app.js')
        <!-- AdminLTE App -->
        <script src="{{ asset('js/adminlte.min.js') }}" defer></script>
    </body>
</html>
