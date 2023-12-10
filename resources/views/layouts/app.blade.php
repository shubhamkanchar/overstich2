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
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('image/logo.png') }}" style="width:50px">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse text-center" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link ms-5 me-5" href="{{ route('products.index') }}"><b>Men</b></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link ms-5 me-5" href="{{ route('login') }}"><b>Women</b></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link ms-5 me-5" href="{{ route('login') }}"><b>Kids</b></a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item ps-xl-2 pe-xl-2">
                            <a class="nav-link" href="{{ route('login') }}"><i class="bi bi-search ms-sm-3 "></i></a>
                        </li>
                        <li class="nav-item ps-xl-2 pe-xl-2">
                            <a class="nav-link" href="{{ route('cart.index') }}"><i class="bi bi-bag fw-bolder"></i></a>
                        </li>
                        <li class="nav-item ps-xl-2 pe-xl-2">
                            <a class="nav-link" href="{{ route('register') }}"><i class="bi bi-heart fw-bolder"></i></a>
                        </li>
                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item ps-xl-2 pe-xl-2">
                            <a class="nav-link" href="{{ route('login') }}"><i class="bi bi-person fs-5"></i></i></a>
                        </li>
                        @endif
                        @if (Route::has('register'))
                        <!-- <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li> -->
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ ucwords(Auth::user()->name) }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                @if(Auth::user()->user_type == 'admin')
                                <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                    Dashboard
                                </a>
                                @elseif(Auth::user()->user_type == 'seller')
                                <a class="dropdown-item" href="{{ route('seller.dashboard') }}">
                                    Dashboard
                                </a>
                                @else
                                <a class="dropdown-item" href="{{ route('user.dashboard') }}">
                                    Dashboard
                                </a>
                                @endif
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <main class="">
            @yield('content')
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