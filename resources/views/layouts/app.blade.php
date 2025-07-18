<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Bootstrap Template CSS -->
    <link href="{{ asset('admin_template/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin_template/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">

</head>
<body>
    <div id="app">
        @include('layouts.template') 

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap Template Scripts -->
    <script src="{{ asset('admin_template/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin_template/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin_template/js/sb-admin-2.min.js') }}"></script>
</body>
</html>
