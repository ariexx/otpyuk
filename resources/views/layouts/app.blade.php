<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <x-meta-tag />
    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- <script src="{{ asset(mix('js/app.js')) }}" defer></script> --}}
    {{-- <script src="{{ asset(mix('js/app.js')) }}" defer data-turbolinks-track="reload"></script> --}}
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('modules/fontawesome/css/all.min.css') }}">
    <script src="{{ asset('modules/jquery.min.js') }}"></script>

    <link href="{{ asset('modules/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('modules/select2/dist/js/select2.min.js') }}"></script>

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('modules/datatables/datatables.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" data-turbo-track="reload">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">

    @livewireStyles
    @bukStyles
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <x-livewire-alert::scripts />
</head>

<body class="layout-3">
    <div id="app">
        <div class="main-wrapper container">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <a href="{{ url('/') }}"
                    class="navbar-brand sidebar-gone-hide">{{ config('app.name', 'Laravel') }}</a>
                <a href="#" class="nav-link sidebar-gone-show" data-toggle="sidebar"><i
                        class="fas fa-bars"></i></a>
                <div class="nav-collapse">
                    <a class="sidebar-gone-show nav-collapse-toggle nav-link" href="#">
                        <i class="fas fa-ellipsis-v"></i>
                    </a>
                </div>
            </nav>

            <nav class="navbar navbar-secondary navbar-expand-lg">
                <div class="container">
                    <ul class="navbar-nav">
                        @guest()
                            @if (Route::has('login'))
                                <li class="nav-item {{ request()->routeIs('login') ? 'active' : '' }}">
                                    <a href="{{ route('login') }}" class="nav-link"><span>{{ __('Login') }}</span></a>
                                </li>
                                <li class="nav-item {{ request()->routeIs('prices.index') ? 'active' : '' }}">
                                    <a href="{{ route('prices.index') }}"
                                        class="nav-link"><span>{{ __('Daftar Harga') }}</span></a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                <a href="{{ url('/home') }}" class="nav-link"><i
                                        class="fas fa-fire"></i><span>Dashboard</span></a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/history-order') }}" class="nav-link"><i
                                        class="fas fa-calendar"></i><span>History Orders</span></a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('logout') }}" class="nav-link"
                                    onclick="event.preventDefault();
                                                                                                                                                                                                                                                    document.getElementById('logout-form').submit();"><i
                                        class="fas fa-arrow-right"></i><span><b>{{ __('Logout') }}</b></span></a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        @endguest
                    </ul>
                </div>
            </nav>


            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    {{-- <div class="section-header">
                        <h1>Top Navigation</h1>
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                            <div class="breadcrumb-item"><a href="#">Layout</a></div>
                            <div class="breadcrumb-item">Top Navigation</div>
                        </div>
                    </div>

                    <div class="section-body">
                        <h2 class="section-title">This is Example Page</h2>
                        <p class="section-lead">This page is just an example for you to create your own page.</p>
                        <div class="card">
                            <div class="card-header">
                                <h4>Example Card</h4>
                            </div>
                            <div class="card-body">
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                            </div>
                            <div class="card-footer bg-whitesmoke">
                                This is card footer
                            </div>
                        </div>
                    </div> --}}
                    @yield('content')
                </section>
            </div>
            <footer class="main-footer">
                <div class="footer-left">
                    Copyright &copy; {{ @date('Y') }} <div class="bullet"></div> OTPYuk
                </div>
                <div class="footer-right">

                </div>
            </footer>
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('modules/popper.js') }}"></script>
    <script src="{{ asset('modules/tooltip.js') }}"></script>
    <script src="{{ asset('modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('modules/moment.min.js') }}"></script>
    <script src="{{ asset('js/stisla.js') }}"></script>

    <!-- JS Libraies -->
    <script src="{{ asset('modules/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('modules/jquery-ui/jquery-ui.min.js') }}"></script>

    <!-- Page Specific JS File -->

    <!-- Template JS File -->
    {{-- <script src="{{ asset('js/scripts.js') }}"></script> --}}
    {{-- <script src="js/custom.js"></script> --}}
    @include('sweetalert::alert')

    @livewireScripts
    {{-- <script src="https://cdn.jsdelivr.net/gh/livewire/turbolinks@v0.1.4/dist/livewire-turbolinks.js"
        data-turbolinks-eval="false" data-turbo-eval="false"></script> --}}
    @stack('scripts')
    @bukScripts

</body>

</html>
