<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('/site.webmanifest') }}">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    @notifyCss
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @stack('styles')
</head>

<body>
    <div id="popup-overlay" class="d-none"></div>
    <div class="spinner d-none">
        <img src="{{ asset('/image/spinner.svg') }}">
    </div>
    <div id="app" class="mb-5">
        @include('backend.admin.layouts.navbar')
        @include('backend.admin.layouts.sidebar')
        <main class="py-4">
            @yield('content')
        </main>
        
    </div>
    @include('backend.admin.layouts.footer')
    <x-notify::notify />
    @notifyJs
    @stack('scripts')
</body>

</html>
@yield('script')