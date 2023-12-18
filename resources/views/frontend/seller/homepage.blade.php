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

    <!-- Scripts -->
    @notifyCss
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>

<body>
    <div id="popup-overlay" class="d-none"></div>
    <div class="spinner d-none">
        <img src="{{ asset('/image/spinner.svg') }}">
    </div>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white mt-2">
            <div class="container">
                <a class="navbar-brand d-flex" href="{{ url('/') }}">
                    <img src="{{ asset('image/logo.png') }}" style="width:50px">
                    <img class="m-3" src="{{ asset('image/logo1.png') }}" style="height: 20px;">
                </a>
                <button class="btn btn-dark">Login</button>
            </div>
        </nav>
        <main class="bg-image" style="background-image:url({{ asset('image/bgcolor.jpg') }})">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 p-5">
                        <h1 class="fw-700">ONE STOP FASHION</h1>
                        <p class="fw-900 custom-fs-1">SELL ON OVERSTITCH</p>
                        <h5>New sellers enjoy Free Registration</h5>
                        <h5>0% commission charge on first 10 orders</h5>
                        <h5>1.5% commission charge on next 100 orders</h5>
                        <h6>*Terms and conditions</h6>
                        <div class="text-center m-5">
                            <a href="{{ route('seller.index') }}" class="btn btn-dark">Register</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <footer class="mt-5" style="background-color: black;">
        <div class="container ">
            <div class="row">
                <div class="col-md-9 mt-4">
                    <p class="text-white fs-5"><i class="bi bi-geo-alt me-2 mb-2"></i>India</p>
                    <p class="text-white fs-5">Contact Us</p>
                    <p class="text-white fs-5">Terms and Conditions</p>
                    <p class="text-white fs-5">Privacy Policy</p>
                    <p class="text-white fs-5">Cookie Setting</p>
                </div>
                <div class="col-md-3 mt-4 d-flex mb-5">
                    <a class="nav-link fs-1 m-2 d-inline text-white" target="_blank" href="https://wa.me/7066856414?text=Hello%20Overstitch"><img style="width: 35px;" src="{{ asset('image/social/whatsapp.png') }}"></b></a>
                    <a class="nav-link fs-1 m-2 d-inline text-white" target="_blank" href="https://www.instagram.com/overstitch.in/"><img style="width: 35px;" src="{{ asset('image/social/instagram.png') }}"></a>
                    <a class="nav-link fs-1 m-2 d-inline text-white" target="_blank" href=" https://www.facebook.com/profile.php?id=100090246980494"><img style="width: 35px;" src="{{ asset('image/social/facebook.png') }}"></a>
                    
                    <a class="nav-link fs-1 m-2 d-inline text-white" target="_blank" href="https://twitter.com/overstitch_in"><img style="width: 35px;" src="{{ asset('image/social/twitter.png') }}"></a>
                </div>
            </div>
        </div>
    </footer>
    <x-notify::notify />
    @notifyJs
</body>
</html>
@yield('script')