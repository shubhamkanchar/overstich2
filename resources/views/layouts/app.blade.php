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

    <!-- Scripts -->
    @notifyCss
    @vite(['public/resources/sass/app.scss', 'public/resources/js/app.js'])
    
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white mt-sm-4">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <span class="d-md-none">
                        <img src="{{ asset('public/image/logo.png') }}" style="width:150px">
                    </span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item ps-xl-4 pe-xl-4">
                            <a class="nav-link" href="{{ route('login') }}">Contact Us</a>
                        </li>
                        <li class="nav-item d-none d-md-block d-lg-block d-xl-block">
                            <a class="nav-link" href="#">|</a>
                        </li>
                        <li class="nav-item ps-xl-4 pe-xl-4">
                            <a class="nav-link" href="{{ route('seller.index') }}">Register as Seller</a>
                        </li>
                    </ul>

                    <ul class="navbar-nav text-center d-none d-md-block d-lg-block d-xl-block">
                        <a href="{{ route('welcome') }}"><img src="{{ asset('public/image/logo.png') }}" style="width:150px"></a>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        <li class="nav-item ps-xl-4 pe-xl-4">
                            <a class="nav-link" href="{{ route('register') }}"><i class="bi bi-bag me-1"></i>Shopping Bag</a>
                        </li>
                        <li class="nav-item ps-xl-4 pe-xl-4">
                            <a class="nav-link" href="{{ route('register') }}"><i class="bi bi-heart me-1"></i>Wishlist</a>
                        </li>

                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item ps-xl-4 pe-xl-4">
                            <a class="nav-link" href="{{ route('login') }}"><i class="bi bi-person fs-5 me-1"></i></i>Sign In</a>
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
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
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
        <nav class="navbar navbar-expand-md navbar-light bg-white mt-lg-4 ">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav" style="width: 39%;">
                        <li class="nav-item ps-xl-4 pe-xl-4">
                            <a class="nav-link" href="{{ route('login') }}"><i class="bi bi-search ms-sm-3 me-2"></i>Search</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav text-center d-none d-md-flex d-lg-flex d-xl-flex">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('products.index') }}">Men</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">|</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Women</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">|</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Kids</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ms-auto">
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Kids</a>
                        </li> -->
                    </ul>
                </div>
            </div>
        </nav>
        <main class="py-4">
            @yield('content')
        </main>
        <footer class="mt-5">
            <div class="container">
                <div class="row">
                    <div class="offset-md-1 col-md-11 col-lg-10 offset-lg-2">
                        <nav class="navbar navbar-expand-md navbar-light bg-white">
                            <ul class="navbar-nav w-100 me-auto text-center">
                                <li class="nav-item ps-xl-4 pe-xl-4">
                                    <a class="nav-link fs-6" href="{{ route('login') }}"><b>TERMS & CONDITIONS</b></a>
                                </li>
                                <li class="nav-item d-none d-md-block d-lg-block d-xl-block">
                                    <a class="nav-link" href="#">|</a>
                                </li>
                                <li class="nav-item ps-xl-4 pe-xl-4">
                                    <a class="nav-link fs-6" href="{{ route('login') }}"><b>PRIVACY POLICY</b></a>
                                </li>
                                <li class="nav-item d-none d-md-block d-lg-block d-xl-block">
                                    <a class="nav-link" href="#">|</a>
                                </li>
                                <li class="nav-item ps-xl-4 pe-xl-4">
                                    <a class="nav-link fs-6" href="{{ route('login') }}"><b>CONTACT US</b></a>
                                </li>
                                <li class="nav-item d-none d-md-block d-lg-block d-xl-block">
                                    <a class="nav-link" href="#">|</a>
                                </li>
                                <li class="nav-item ps-xl-4 pe-xl-4">
                                    <a class="nav-link fs-6" href="{{ route('login') }}"><b>COOKIE SETTING</b></a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-12 text-center">
                        <a class="nav-link fs-1 m-1 d-inline" href="{{ route('login') }}"><b><i class="bi bi-instagram"></i></b></a>
                        <a class="nav-link fs-1 m-1 d-inline" href="{{ route('login') }}"><b><i class="bi bi-facebook"></i></b></a>
                        <a class="nav-link fs-1 m-1 d-inline" href="{{ route('login') }}"><b><i class="bi bi-whatsapp"></i></b></a>
                        <a class="nav-link fs-1 m-1 d-inline" href="{{ route('login') }}"><b><i class="bi bi-twitter"></i></b></a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <x-notify::notify />
    @notifyJs
</body>
</html>
@yield('script')