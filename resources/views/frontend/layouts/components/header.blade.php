<header class="position-relative">
    <div class="nav align-items-center justify-content-center">
        <a href={{route('site.index')}} class="py-3">
            <h1 class="mx-3">جمعية أدندان الخيرية</h1>
            <p class="slogan mb-0 text-center">
                <small>تأسست عام 1908م، و المشهرة برقم 568</small>
            </p>
        </a>
    </div>
    <div class="navbar navbar-expand-lg navbar-light p-0">
        <div class="container-fluid">
            <button class="btn bg-primary" id="menu" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
                <i class="fa-duotone fa-bars text-white py-1"></i>
            </button>
            @include('frontend.layouts.components.navigation')
        </div>
    </div>
</header>
