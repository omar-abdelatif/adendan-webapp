<header class="position-relative">
    <div class="nav nav-underline align-items-center justify-content-center">
        <a href={{route('site.index')}} class="py-3">
            <h1 class="mx-3 text-md-end text-sm-end">جمعية أدندان الخيرية</h1>
            <p class="slogan mb-0 text-center">
                <small>تأسست عام 1908م، و المشهرة برقم 568</small>
            </p>
        </a>
    </div>
    <div class="navbar navbar-expand-md navbar-light bg-white p-0">
        <div class="container-fluid">
            <button id="mobileMenuBtn" class="navbar-toggler p-0 border-0 ms-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#navbarMenu" aria-expanded="false" aria-label="القائمة" accesskey="ق">
                <span class="navbar-toggler-icon" aria-hidden="true"></span>
            </button>
            <a href={{route('site.index')}} class="navbar-brand d-block d-md-none me-0 ps-3">
                <h1>جمعية أدندان الخيرية</h1>
            </a>
            @include('frontend.layouts.components.navigation')
        </div>
    </div>
</header>
