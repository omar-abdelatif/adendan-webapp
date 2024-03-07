<nav class="offcanvas offcanvas-start w-75" id="navbarMenu" aria-label="القائمة الجانبية" aria-describedby="mainMenuDescription">
    <div id="closeMenuFocusout" data-bs-dismiss="offcanvas" class="d-block d-md-none" style="height: 100%;position: absolute;top: 0;width: 25%;left: 0;" role="button" aria-label="القائمة" tabindex="0" aria-expanded="true" accesskey="ق"></div>
    <div class="navbar-mobile d-flex flex-column justify-content-between w-100">
        <div class="d-block d-md-flex align-items-md-center">
            <div class="d-block d-md-none text-end pt-3">
                <button id="closeNavbar" class="btn pb-0" type="button" aria-hidden="true" tabindex="-1">
                    <i class="fas fa-chevron-right" style="font-size: 22px;"></i>
                </button>
            </div>
            <ul class="navbar-nav m-auto" aria-label="القائمة الرئيسية" aria-owns="extraMenuItem1 extraMenuItem2 extraMenuItem3">
                <li class="nav-item {{ request()->routeIs('site.index') ? 'active' : '' }}">
                    <a class="nav-link rounded-pill bg-primary rounded text-white" href={{route('site.index')}}>الرئيسية</a>
                </li>
                <li class="nav-item {{ request()->routeIs('site.borders') ? 'active' : '' }}">
                    <a class="nav-link rounded-pill bg-primary rounded text-white" href="{{route('site.borders')}}">مجلس الإدارة</a>
                </li>
                <li class="nav-item {{ request()->routeIs('site.assossiation') ? 'active' : '' }}">
                    <a class="nav-link rounded-pill bg-primary rounded text-white" href="{{route('site.assossiation')}}">لجان الجمعية</a>
                </li>
                <li class="nav-item {{ request()->routeIs('site.search') ? 'active' : '' }}">
                    <a class="nav-link rounded-pill bg-primary rounded text-white" href="{{route('site.search')}}" accesskey="ش">
                        الإستعلامات
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" id="dropdown03" class="nav-link d-flex align-items-center rounded-pill position-relative bg-primary rounded text-white" aria-haspopup="true" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        عن الجمعية
                        <i class="fa-solid fa-angle-down ms-2"></i>
                    </a>
                    <div class="dropdown-menu border-0 py-5">
                        <div class="container d-flex flex-column align-items-center flex-md-row justify-content-center p-0" role="list" aria-labelledby="dropdown03">
                            <div role="listitem">
                                <a class="dropdown-item rounded-pill bg-primary rounded text-white text-center p-2" accesskey="ع" href="{{route('site.about')}}">
                                    من نحن
                                </a>
                            </div>
                            <div role="listitem">
                                <a class="dropdown-item rounded-pill bg-primary rounded text-white text-center p-2" href="{{route('site.contact')}}" accesskey="ش">
                                    تواصل معنا
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
                @if (Auth::user())
                    <li class="nav-item">
                        <a href={{route('home')}} class="nav-link rounded-pill bg-primary rounded text-white" target="_blank">لوحة التحكم</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
