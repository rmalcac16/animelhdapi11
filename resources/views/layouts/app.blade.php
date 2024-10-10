<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name') }} - {{ __('Administration') }}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/bootstrap.min.css') }}">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <!-- Custom Font Icons CSS-->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/font.css') }}">
    <!-- Google fonts - Muli-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,700">
    <!-- Favicon-->
    <link rel="shortcut icon" href="{{ asset('assets/admin/images/favicon.ico') }}">

    @livewireStyles
    @stack('styles')

    <!-- Theme stylesheet-->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/style.default.premium.css') }}" id="theme-stylesheet">
    <!-- Custom stylesheet-->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/custom.css') }}">
</head>

<body>
    <header class="header">
        <nav class="navbar navbar-expand-lg">
            <div class="search-panel">
                <div class="search-inner d-flex align-items-center justify-content-center">
                    <div class="close-btn">Close <i class="fa fa-close"></i></div>
                    <form id="searchForm" action="#">
                        <div class="form-group">
                            <input type="search" name="search" placeholder="What are you searching for...">
                            <button type="submit" class="submit">Search</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="container-fluid d-flex align-items-center justify-content-between">
                <div class="navbar-header">
                    <!-- Navbar Header-->
                    <a href="index.html" class="navbar-brand">
                        <div class="brand-text brand-big visible text-uppercase">
                            <strong class="text-primary">Kawaii</strong><strong>Animes</strong>
                        </div>
                        <div class="brand-text brand-sm">
                            <strong class="text-primary">K</strong><strong>A</strong>
                        </div>
                    </a>
                    <!-- Sidebar Toggle Btn-->
                    <button class="sidebar-toggle"><i class="fa fa-long-arrow-left"></i></button>
                </div>
                <div class="right-menu list-inline no-margin-bottom">
                    <div class="list-inline-item logout">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="nav-link text-white"
                                style="background: none; border:0; outline:0">
                                <span class="d-none d-sm-inline">{{ __('Logout') }} </span><i class="icon-logout"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <div class="d-flex align-items-stretch">
        <!-- Sidebar Navigation-->
        <nav id="sidebar">
            <!-- Sidebar Header-->
            <div class="sidebar-header d-flex align-items-center">
                <a href="pages-profile.html">
                    <div class="avatar">
                        <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?background=random&name=' . urlencode(Auth::user()->name) }}"
                            alt="..." class="img-fluid rounded-circle">
                    </div>
                </a>
                <div class="title">
                    <h1 class="h5">{{ Auth::user()->name }}</h1>
                    <p>{{ Auth::user()->email }}</p>
                </div>
            </div>
            <!-- Sidebar Navigation Menus-->
            <span class="heading">{{ __('Main') }}</span>
            <ul class="list-unstyled">
                <li @if (request()->routeIs('admin.dashboard')) class="active" @endif>
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="icon-home"></i>{{ __('Home') }}
                    </a>
                </li>
                <li @if (request()->routeIs('admin.animes*')) class="active" @endif>
                    <a href="{{ route('admin.animes.index') }}">
                        <i class="icon-writing-whiteboard"></i>{{ __('Animes') }}
                    </a>
                </li>
                <li @if (request()->routeIs('admin.settings')) class="active" @endif>
                    <a href="{{ route('admin.settings') }}">
                        <i class="icon-settings"></i>{{ __('Settings') }}
                    </a>
                </li>
            </ul>
            <span class="heading">{{ __('External') }}</span>
            <ul class="list-unstyled">
                <li @if (request()->routeIs('admin.external.voe*')) class="active" @endif>
                    <a href="#voeDropdown" @if (request()->routeIs('admin.external.voe*')) aria-expanded="true" @endif
                        data-toggle="collapse">
                        <i class="icon-website"></i>{{ __('Voe') }}
                    </a>
                    <ul id="voeDropdown" class="collapse list-unstyled @if (request()->routeIs('admin.external.voe*')) show @endif">
                        <li @if (request()->routeIs('admin.external.voe.clone')) class="active" @endif>
                            <a href="{{ route('admin.external.voe.clone') }}">{{ __('Clone') }}</a>
                        </li>
                        <li @if (request()->routeIs('admin.external.voe.move')) class="active" @endif>
                            <a href="{{ route('admin.external.voe.move') }}">{{ __('Move') }}</a>
                        </li>
                    </ul>
                </li>
                <li @if (request()->routeIs('admin.external.filemoon*')) class="active" @endif>
                    <a href="#filemoonDropdown" @if (request()->routeIs('admin.external.filemoon*')) aria-expanded="true" @endif
                        data-toggle="collapse">
                        <i class="icon-website"></i>{{ __('Filemoon') }}
                    </a>
                    <ul id="filemoonDropdown"
                        class="collapse list-unstyled @if (request()->routeIs('admin.external.filemoon*')) show @endif">
                        <li @if (request()->routeIs('admin.external.filemoon.clone')) class="active" @endif>
                            <a href="{{ route('admin.external.filemoon.clone') }}">{{ __('Clone') }}</a>
                        </li>
                    </ul>
                </li>
                <li @if (request()->routeIs('admin.external.lulustream*')) class="active" @endif>
                    <a href="#lulustreamDropdown" @if (request()->routeIs('admin.external.lulustream*')) aria-expanded="true" @endif
                        data-toggle="collapse">
                        <i class="icon-website"></i>{{ __('Lulustream') }}
                    </a>
                    <ul id="lulustreamDropdown"
                        class="collapse list-unstyled @if (request()->routeIs('admin.external.lulustream*')) show @endif">
                        <li @if (request()->routeIs('admin.external.lulustream.clone')) class="active" @endif>
                            <a href="{{ route('admin.external.lulustream.clone') }}">{{ __('Clone') }}</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>

        <div class="page-content">
            @hasSection('content')
                @yield('content')
            @else
                {{ $slot }}
            @endif
            <footer class="footer">
                <div class="footer__block block no-margin-bottom">
                    <div class="container-fluid text-center">
                        <p class="no-margin-bottom">&copy; {{ date('Y') }} - {{ config('app.name') }} -
                            {{ __('All rights reserved.') }}</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- JavaScript files-->
    <script src="{{ asset('assets/admin/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/jquery.cookie.js') }}"></script>
    <script src="{{ asset('assets/admin/js/front.js') }}"></script>

    @livewireScripts
    @stack('scripts')
</body>

</html>
