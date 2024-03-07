<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="theme-color" content="#2d6c81" />
    <meta name="description" content="">
    <meta name="keywords" content="جميعة الرسالة, جمعية مصر الخير, جمعية الأورمان">
    <meta name="author" content="جمعية أدندان الخيرية">
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <meta property="og:url" content="https://adendan.website/">
    <meta property="og:title" content="جمعية أدندان الخيرية">
    <meta property="og:description" content="جمعية أدندان الخيرية">
    <meta property="og:image" content="{{ asset('assets/images/favicon.png') }}">
    @vite('resources/js/app.js')
    <title>جمعية أدندان الخيرية</title>
    @include('frontend.layouts.assets.css')
</head>
    <body>
        <div id="fb-root"></div>
        <div class="wrapper layout-1">
            @if (Route::current()->getName() == 'site.index')
                <div class="audio-play">
                    <audio autoplay>
                        <source src="{{asset('assets/melody/profet_mohamed.mp3')}}" type="audio/mp3">
                    </audio>
                </div>
            @endif
            @include('frontend.layouts.components.header')
            <main>
                @if (Route::currentRouteName() !== 'site.index')
                    <div class="container">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 py-4">
                                @yield('breadcrumb-items')
                            </ol>
                        </nav>
                    </div>
                @endif
                @yield('site')
            </main>
        </div>
        @include('frontend.layouts.components.footer')
    </body>
</html>
