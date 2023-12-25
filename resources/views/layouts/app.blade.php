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
    @stack('styles')
</head>

<body>
    <div id="popup-overlay" class="d-none"></div>
    <div class="spinner d-none">
        <img src="{{ asset('/image/spinner.svg') }}">
    </div>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('image/logo.png') }}" style="width:50px">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse text-center" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto">
                        @foreach ($categories as $category)
                            <div  class="main-category" id="mainCategory{{$category->id}}">
                                <li class="nav-item d-flex justify-content-between">
                                    <a class="nav-link ms-5 d-inline-block text-nowrap fs-4" href="{{ route('products.index', $category->id) }}"><b>{{ ucfirst($category->category)}}</b></a>
                                    {{-- <span class="bi mt-4 bi-caret-down me-5 show-subcategory d" data-target="#subcategory{{$category->id}}"></span> --}}
                                    <span class="bi bi-caret-down align-self-center me-5 d-none d-md-inline show-subcategory" data-target="#subcategory{{ $category->id }}"></span>
        
                                    <span class="bi fs-4 align-self-center text-secondary me-5 d-inline-block d-md-none show-subcategory" data-target="#subcategory{{ $category->id }}">></span>
                                </li>
                            </div> 
                        @endforeach
                        
                    </ul>
                    <ul class="navbar-nav ms-auto nav-right-content">
                        <li class="nav-item ps-xl-2 pe-xl-2">
                            <a class="nav-link" href="{{ route('login') }}"><i class="bi bi-search ms-sm-3 "></i></a>
                        </li>
                        <li class="nav-item ps-xl-2 pe-xl-2">
                            <a class="nav-link" href="{{ route('cart.index') }}">
                                <span class="position-relative p-1">
                                    <i class="bi bi-bag fw-bolder"></i>
                                    @if($cartCount > 0)
                                        <span class="position-absolute top-1 start-100 translate-middle badge rounded-pill bg-secondary" >
                                            {{ $cartCount }}
                                            <span class="visually-hidden">Cart Count</span>
                                        </span>
                                    @endif
                                </span>
                                
                            </a>
                        </li>
                        <li class="nav-item ps-xl-2 pe-xl-2">
                            <a class="nav-link" href="{{ route('wishlist.index') }}"><i class="bi bi-heart fw-bolder"></i></a>
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
                                <a class="dropdown-item" href="{{ route('order.my-order') }}">
                                    Orders
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
        <div class="relative">
            @foreach ($categories as $category)
                <div class="container-fluid text-start child-categories" style="display: none;position: absolute;
                left: 0px;
                top: 0px;
                z-index: 1;" id="subcategory{{$category->id}}">
                    <div class="row flex-wrap bg-white border-2 subcategory-row border-top-0">
                        {!! $categoryTree->categoryTreeView($category->children, $category->id) !!}
                    </div>
                </div>
            @endforeach
        </div>
        <main class="" style="min-height: 45vh;">
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