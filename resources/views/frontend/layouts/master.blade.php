<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="UTF-8">
        @vite('resources/js/app.js')
        <title>جمعية أدندان الخيرية</title>
        <meta name="theme-color" content="#2d6c81" />
        <meta name="author" content="جمعية أدندان الخيرية">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="description" content="جمعية أدندان الخيرية">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
        @yield('meta')
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
        <meta name="keywords" content="جميعة الرسالة, جمعية مصر الخير, جمعية الأورمان, جميعة أدندان الخيرية, أدندان">
        @include('frontend.layouts.assets.css')
    </head>
    <body oncontextmenu="return false;">
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
