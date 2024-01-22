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
                <a href="{{ 'http://www.'.env('DOMAIN').'/login' }}" class="btn btn-dark">Login</a>
            </div>
        </nav>
        <main class="bg-image" style="background-image:url({{ asset('image/bgcolor.jpg') }})">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 p-5">
                        <h1 class="fw-700 mt-4 mb-4">SELL ON OVERSTITCH</h1>
                        <div class="fw-700 custom-fs-1 m-0 lh-1 mt-5">0% COMMISSION FEE</div>
                        <div class="fw-700 custom-fs-1 m-0 lh-1">FREE REGISTRATION</div>
                        <a href="#" class="mt-2" data-bs-toggle="modal" data-bs-target="#exampleModal">*Terms and conditions</a>
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
                <div class="col-md-3 col-6 mt-4">
                    <p class="text-white fs-5"><i class="bi bi-geo-alt me-2 mb-2"></i>India</p>
                    <p class="text-white fs-5"><a href="{{ route('rp') }}" class="text-decoration-none text-white">Return & Refund Policy</a></p>
                    <p class="text-white fs-5"><a href="{{ route('tc') }}" class="text-decoration-none text-white">Terms and Conditions</a></p>
                    <p class="text-white fs-5"><a href="{{ route('pp') }}" class="text-decoration-none text-white">Privacy Policy</a></p>
                    <p class="text-white fs-5"><a href="{{ route('sp') }}" class="text-decoration-none text-white">Shipping Policy</a></p>
                </div>
                <div class="col-md-6 col-6 mt-4">
                    <p class="text-white fs-5"></p>
                    <p class="text-white fs-5">Contact Us</p>
                    <p class="text-white fs-5">About Us</p>
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
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Terms and Conditions</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Please note that 0% fee is only applicable to commission charges. Other charges, such as GST charges, Shipping charges, Weight discrepancy charge, Payment processing charges will still apply.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
@yield('script')