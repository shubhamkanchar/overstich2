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
    <style>
        @media only screen and (min-width: 575px) {
            .show-md-subcategory:hover {
                text-decoration: underline;
            }
        }

        @media (min-width: 768px) {
            .position-md-absolute {
                position: absolute !important;
            }
        }
    </style>
    @stack('styles')
</head>

<body>
    <div id="popup-overlay" class="d-none"></div>
    <div class="spinner d-none">
        <img src="{{ asset('/image/spinner.svg') }}">
    </div>
    <div id="app">
        
        <nav class="navbar navbar-expand-lg navbar-light bg-white">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('image/logo.png') }}" style="width:50px">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse text-center" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto">
                        @foreach ($categories as $category)
                            <div class="main-category">
                                <li class="nav-item d-flex justify-content-between">
                                    <a class="nav-link ms-5 d-inline-block text-nowrap fs-6 show-md-subcategory"
                                        href="{{ route('products.index', $category->id) }}"
                                        id="mainCategory{{ $category->id }}"
                                        data-target="#subcategory{{ $category->id }}"
                                        role="button"><b>{{ strtoupper($category->category) }}</b></a>
                                    {{-- <span class="bi mt-4 bi-caret-down me-5 show-subcategory d" data-target="#subcategory{{$category->id}}"></span> --}}
                                    {{-- <span class="bi bi-caret-down align-self-center me-5 d-none d-md-inline show-subcategory" data-target="#subcategory{{ $category->id }}"></span> --}}

                                    <span
                                        class="bi fs-4 align-self-center text-secondary me-5 d-inline-block d-md-none show-sm-subcategory"
                                        data-target="#subcategory{{ $category->id }}">></span>
                                </li>
                            </div>
                        @endforeach

                    </ul>
                    <ul class="navbar-nav ms-auto nav-right-content">
                        <li class="nav-item ps-xl-2 pe-xl-2">
                            <a class="nav-link" href="javascript:void(0)">
                                <form id="searchForm" class="d-flex" action="{{ route('search-product') }}" method="GET">
                                    <input class="form-control rounded-pill pe-4" type="text" id="example-search-input" name="search" value="{{ request()->search ?? ''}}">
                                    <button type="submit" class="btn d-none"></button>
                                    <i role="button" onclick="document.getElementById('searchForm').submit()" class="bi bi-search mt-1" style="margin-left:-25px"></i>
                                </form>
                            </a>
                        </li>
                        <li class="nav-item ps-xl-2 pe-xl-2">
                            <a class="nav-link" href="{{ route('cart.index') }}">
                                <span class="position-relative p-1">
                                    {{-- <i class="bi bi-bag fw-bolder"></i> --}}
                                    <i class="bi bi-cart-check-fill fs-4"></i>
                                    @if ($cartCount > 0)
                                        <span
                                            class="position-absolute top-1 start-100 translate-middle badge rounded-pill bg-secondary">
                                            {{ $cartCount }}
                                            <span class="visually-hidden">Cart Count</span>
                                        </span>
                                    @endif
                                </span>

                            </a>
                        </li>
                        <li class="nav-item ps-xl-2 pe-xl-2">
                            <a class="nav-link" href="{{ route('wishlist.index') }}">
                                {{-- <i class="bi bi-heart fw-bolder"></i> --}}
                                <i class="bi bi-heart-fill fs-4"></i>
                            </a>
                        </li>
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item ps-xl-2 pe-xl-2">
                                    <a class="nav-link" href="{{ route('login') }}">
                                        {{-- <i class="bi bi-person fs-5"></i> --}}
                                        <i class="bi bi-person-fill fs-4"></i>
                                    </a>
                                </li>
                            @endif
                            @if (Route::has('register'))
                                <!-- <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </li> -->
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ ucwords(Auth::user()->name) }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    @if (Auth::user()->user_type == 'admin')
                                        <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                            Dashboard
                                        </a>
                                    @elseif(Auth::user()->user_type == 'seller')
                                        <a class="dropdown-item" href="{{ route('seller.dashboard') }}">
                                            Dashboard
                                        </a>
                                    @else
                                        <!-- <a class="dropdown-item" href="{{ route('user.dashboard') }}">
                                        Dashboard
                                    </a> -->
                                        <a class="dropdown-item" href="{{ route('order.my-order') }}">
                                            Orders
                                        </a>
                                        <a class="dropdown-item" href="{{ route('addresses.index') }}">
                                            Address
                                        </a>
                                    @endif
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <div class="position-md-absolute category-menu w-100" style="z-index: 999">
            {{-- @dd($categories); --}}
            @foreach ($categories as $category)
                <div class="container-fluid text-start child-categories"
                    data-target="#subcategory{{ $category->id }}" style="display: none;"
                    id="subcategory{{ $category->id }}">
                    <div class="row flex-wrap bg-white border-2 border-top-0">
                        <div class="d-md-none d-flex justify-content-end close-category-menu text-end bg-white">
                            <span
                                class="fs-1 align-self-center text-secondary d-inline-block d-md-none bi bi-x"></span>
                        </div>
                        <div class="d-md-none d-flex justify-content-between text-end bg-white mb-3">
                            <span
                                class="ms-5 align-self-center d-inline-block d-md-none text-nowrap fs-6 "><b>{{ strtoupper($category->category) }}</b></span>
                            <span
                                class="bi fs-4 align-self-center text-secondary me-5 d-inline-block d-md-none show-sm-subcategory"
                                data-target="#subcategory{{ $category->id }}">></span>
                        </div>
                        @foreach ($category->subCategory as $subCategory)
                            <div class="col-sm-12 offset-md-1 col-md-2 text-start">
                                <div class="d-flex justify-content-between">
                                    <a class="nav-link ms-5 me-1 mb-1 d-inline-block fs-md-4  fs-6 fw-md-bold fw-semibold align-self-center"
                                        href="{{ route('products.index', $subCategory->id) }}">{{ ucfirst($subCategory->category) }}</a>
                                    <span
                                        class="bi bi fs-4 text-secondary me-5 d-inline-block d-md-none align-self-center show-nested-subcategory"
                                        data-target="#subcategories{{ $subCategory->id }}"> > </span>
                                </div>
                                <div id="subcategories{{ $subCategory->id }}"
                                    class="childs d-none d-md-inline-block">
                                    @foreach ($subCategory->childCategory as $childCategory)
                                        <div class="d-flex justify-content-between">
                                            <a class="nav-link ms-5 me-1 mb-1 d-inline-block align-self-center"
                                                href="{{ route('products.index', $childCategory->id) }}">{{ ucfirst($childCategory->category) }}</a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
        <main class="" style="min-height: 45vh;">
            @yield('content')
        </main>
        <div id="snackbar">Some text some message..</div>
    </div>
    <footer class="mt-5" style="background-color: black;">
        <div class="container ">
            <div class="row">
                <div class="col-md-3 col-6 mt-4">
                    <p class="text-white fs-5"><i class="bi bi-geo-alt me-2 mb-2"></i>India</p>
                    <p class="text-white fs-5"><a href="{{ route('rp') }}"
                            class="text-decoration-none text-white">Return & Refund Policy</a></p>
                    <p class="text-white fs-5"><a href="{{ route('tc') }}"
                            class="text-decoration-none text-white">Terms and Conditions</a></p>
                    <p class="text-white fs-5"><a href="{{ route('pp') }}"
                            class="text-decoration-none text-white">Privacy Policy</a></p>
                    <p class="text-white fs-5"><a href="{{ route('sp') }}"
                            class="text-decoration-none text-white">Shipping Policy</a></p>
                </div>
                <div class="col-md-6 col-6 mt-4">
                    <p class="text-white fs-5"></p>
                    <p class="text-white fs-5"><a class="text-decoration-none text-white"
                            href="{{ route('contact_us') }}">Contact Us</a></p>
                    <p class="text-white fs-5"><a class="text-decoration-none text-white"
                            href="{{ route('about_us') }}">About Us</a></p>
                    {{-- <p class="text-white fs-5">Cookie Setting</p> --}}
                </div>
                <div class="col-md-3 mt-4 d-flex mb-5">
                    <a class="nav-link fs-1 m-2 d-inline text-white" target="_blank"
                        href="https://wa.me/7066856414?text=Hello%20Overstitch"><img style="width: 35px;"
                            src="{{ asset('image/social/whatsapp.png') }}"></b></a>
                    <a class="nav-link fs-1 m-2 d-inline text-white" target="_blank"
                        href="https://www.instagram.com/overstitchindia"><img style="width: 35px;"
                            src="{{ asset('image/social/instagram.png') }}"></a>
                    {{-- <a class="nav-link fs-1 m-2 d-inline text-white" target="_blank" href=" https://www.facebook.com/profile.php?id=100090246980494"><img style="width: 35px;" src="{{ asset('image/social/facebook.png') }}"></a> --}}
                    <a class="nav-link fs-1 m-2 d-inline text-white" target="_blank"
                        href="https://twitter.com/overstitch_in"><img style="width: 35px;"
                            src="{{ asset('image/social/twitter.png') }}"></a>
                </div>
            </div>
        </div>
    </footer>
    <x-notify::notify />
    @notifyJs
    @if(!empty(session('msg')))
        <script>
                var x = document.getElementById("snackbar");
                x.className = "show";
                x.innerHTML = "{{ session('msg') }}"
                setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
        </script>
        @php
        request()->session()->forget('msg');
        @endphp
    @endif
</body>

</html>
@yield('script')
