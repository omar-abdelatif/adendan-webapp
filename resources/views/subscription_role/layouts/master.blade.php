<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="جمعية أدندان الخيرية">
    <meta property="og:url" content="https://adendan.com/">
    <meta property="og:title" content="جمعية أدندان الخيرية">
    <meta property="og:description" content="جمعية أدندان الخيرية">
    <meta property="og:image" content="{{ asset('assets/images/favicon.png') }}">
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <title>@yield('title')</title>
    {{-- ! Vite ! --}}
    @vite('resources/js/app.js')
    @include('layouts.assets.css')
</head>

<body class="dark-only rtl">
    <div class="loader-wrapper">
        <div class="loader-index">
            <span></span>
        </div>
        <svg>
            <defs></defs>
            <filter id="goo">
                <fegaussianblur in="SourceGraphic" stddeviation="11" result="blur"></fegaussianblur>
                <fecolormatrix in="blur" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo">
                </fecolormatrix>
            </filter>
        </svg>
    </div>
    {{-- ! Tap On Top Starts ! --}}
    <div class="tap-top">
        <i data-feather="chevrons-up"></i>
    </div>
    {{-- ! Page Wrapper Start ! --}}
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        {{-- ! Page Header Start ! --}}
        @include('layouts.components.header')
        {{-- ! Page Body Start ! --}}
        <div class="page-body-wrapper">
            {{-- ! Page Sidebar Start ! --}}
            @include('subscription_role.layouts.components.navigation')
            <div class="page-body">
                <div class="container-fluid">
                    <div class="page-title">
                        <div class="row align-items-center">
                            <div class="col-6">
                                @yield('breadcrumb-title')
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-center justify-content-end">
                                    @yield('modals')
                                    <ol class="ms-3 breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a href="{{ route('home') }}">
                                                <svg class="stroke-icon">
                                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                                                </svg>
                                            </a>
                                        </li>
                                        @yield('breadcrumb-items')
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- ! Container-Fluid Starts ! --}}
                @yield('content')
            </div>
            {{-- ! Footer Start ! --}}
            @include('layouts.components.footer')
        </div>
    </div>
    {{-- ! Scripts ! --}}
    @include('layouts.assets.script')
</body>

</html>
