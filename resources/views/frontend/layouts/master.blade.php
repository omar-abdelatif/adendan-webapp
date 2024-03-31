<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        @yield('meta')
        <meta charset="UTF-8">
        @vite('resources/js/app.js')
        <title>جمعية أدندان الخيرية</title>
        @include('frontend.layouts.assets.css')
        <meta name="theme-color" content="#2d6c81" />
        <meta name="author" content="جمعية أدندان الخيرية">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta property="og:url" content="https://adendan.com/">
        <meta name="description" content="جمعية أدندان الخيرية">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta property="og:image" content="{{ asset('assets/images/favicon.png') }}">
        <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
        <meta name="keywords" content="جميعة الرسالة, جمعية مصر الخير, جمعية الأورمان, جميعة أدندان الخيرية, أدندان">
    </head>
    <body>
        <div id="fb-root"></div>
        <div class="wrapper layout-1">
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
