<div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">القائمة الجانبية</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="navbar-nav m-auto" aria-label="القائمة الرئيسية" aria-owns="extraMenuItem1 extraMenuItem2 extraMenuItem3">
            <li class="nav-item {{ request()->routeIs('site.index') ? 'active' : '' }}">
                <a class="nav-link rounded-pill bg-primary" href={{route('site.index')}}>الرئيسية</a>
            </li>
            <li class="nav-item {{ request()->routeIs('site.borders') ? 'active' : '' }}">
                <a class="nav-link rounded-pill bg-primary" href="{{route('site.borders')}}">مجلس الإدارة</a>
            </li>
            <li class="nav-item {{ request()->routeIs('workers.index') ? 'active' : ''}}">
                <a class="nav-link rounded-pill bg-primary" href="{{route('workers.index')}}">حرف و خدمات</a>
            </li>
            <li class="nav-item {{ request()->routeIs('site.assossiation') ? 'active' : '' }}">
                <a class="nav-link rounded-pill bg-primary" href="{{route('site.assossiation')}}">لجان الجمعية</a>
            </li>
            <li class="nav-item {{ request()->routeIs('site.search') ? 'active' : '' }}">
                <a class="nav-link rounded-pill bg-primary" href="{{route('site.search')}}">
                    الإستعلامات
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link bg-primary rounded-pill" href="#" type="button" data-coreui-toggle="dropdown" aria-expanded="false">
                    عن الجمعية
                    <i class="fa-solid fa-angle-down ms-2"></i>
                </a>
                <ul class="dropdown-menu">
                    <div class="container d-flex justify-content-center py-4">
                        <li>
                            <a class="dropdown-item rounded-pill text-white bg-primary rounded text-center p-2" href="{{route('site.about')}}">
                                من نحن
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item rounded-pill text-white bg-primary rounded text-center p-2" href="{{route('site.contact')}}">
                                تواصل معنا
                            </a>
                        </li>
                    </div>
                </ul>
            </li>
            @if (Auth::user())
                <li class="nav-item">
                    <a href={{route('home')}} class="nav-link rounded-pill bg-primary rounded" target="_blank">لوحة التحكم</a>
                </li>
            @endif
        </ul>
    </div>
</div>
