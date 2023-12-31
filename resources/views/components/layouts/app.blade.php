<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title : config('app.name', 'Laravel') }}</title>

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

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="{{ asset('js/adminlte.min.js') }}" defer></script>

</head>
<body class="sidebar-mini layout-fixed">
    <div class="wrapper">

        <livewire:layout.navigation />
        <livewire:nav.aside-nav-menu-bar />

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        <!-- /.content-wrapper -->

        <livewire:nav.control-bar />

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
                Anything you want
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
        </footer>

    </div>
</body>
</html>
