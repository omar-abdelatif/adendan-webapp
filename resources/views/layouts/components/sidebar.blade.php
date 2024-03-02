<div class="sidebar-wrapper" sidebar-layout="stroke-svg">
    <div>
        <div class="logo-wrapper">
            <a href="{{ route('home') }}">
                <h3>جمعية أدندان الخيرية</h3>
            </a>
            <div class="toggle-sidebar">
                <i class="status_toggle middle sidebar-toggle" data-feather="grid"></i>
            </div>
        </div>
        <div class="logo-icon-wrapper text-center mt-3 mb-5 mx-3 p-0">
            <a href={{route('home')}}>
                <img class="img-fluid me-0" src="{{ asset('assets/images/logo/لوجو الجمعية.png') }}" width="70" alt="Logo">
            </a>
        </div>
        <nav class="sidebar-main">
            <div id="sidebar-menu">
                <ul class="sidebar-links w-100" id="simple-bar">
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="{{ route('home') }}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                            </svg>
                            <span>لوحة التحكم</span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="{{route('news.all')}}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-form') }}"></use>
                            </svg>
                            <span>الأخبار </span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-user') }}"></use>
                            </svg>
                            <span>المشتركين</span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <a href="{{route('board.all')}}" class="sidebar-link sidebar-title">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-user') }}"></use>
                            </svg>
                            <span>مجلس الإدارة</span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <a href="{{route('association.all')}}" class="sidebar-link sidebar-title">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                            </svg>
                            <span>لجان الجميعة</span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <a href="{{route('workers.all')}}" class="sidebar-link sidebar-title">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-user') }}"></use>
                            </svg>
                            <span>حرفيين</span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <a href="" class="sidebar-link sidebar-title">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#profit') }}"></use>
                            </svg>
                            <span>التبرعات</span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <a href="{{route('tomb.all')}}" class="sidebar-link sidebar-title">
                            <i class="fa-solid fa-tombstone-blank text-white me-3"></i>
                            <span>المقابر</span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <a href="" class="sidebar-link sidebar-title">
                            <i class="fa-duotone fa-rings-wedding text-white me-3"></i>
                            <span>الأفراح</span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <a href="#" class="sidebar-link sidebar-title">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-form') }}"></use>
                            </svg>
                            <span>التقارير</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li>
                                <a href="{{route('reports.subscriptions')}}">
                                    <svg class="stroke-icon">
                                        <use href="{{ asset('assets/svg/icon-sprite.svg#profit') }}"></use>
                                    </svg>
                                    <span>الإشتراكات</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('reports.location')}}">
                                    <svg class="stroke-icon">
                                        <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                                    </svg>
                                    <span>السكن</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('reports.age')}}">
                                    <svg class="stroke-icon">
                                        <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-form') }}"></use>
                                    </svg>
                                    <span>السن</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('reports.jobs')}}">
                                    <svg class="stroke-icon">
                                        <use href="{{ asset('assets/svg/icon-sprite.svg#fill-job-search') }}"></use>
                                    </svg>
                                    <span>الوظائف</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-list">
                        <a href="" class="sidebar-link sidebar-title">
                            <i data-feather="log-in" class="text-white"></i>
                            <span>سجل تسجيل الدخول</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
