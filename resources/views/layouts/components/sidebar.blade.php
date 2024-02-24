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
                        <a class="sidebar-link sidebar-title" href="{{ route('home') }}" target="_blank">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                            </svg>
                            <span>لوحة التحكم</span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="" target="_blank">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-form') }}"></use>
                            </svg>
                            <span>الأخبار </span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="" target="_blank">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-user') }}"></use>
                            </svg>
                            <span>الإشتراكات</span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <a href="" class="sidebar-link sidebar-title">
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-user') }}"></use>
                            </svg>
                            <span>مجلس الإدارة</span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <a href="" class="sidebar-link sidebar-title">
                            <svg class="fill-icon">
                                <use></use>
                            </svg>
                            <span>لجان الجميعة</span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <a href="" class="sidebar-link sidebar-title">
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-user') }}"></use>
                            </svg>
                            <span>حرفيين</span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <a href="" class="sidebar-link sidebar-title">
                            <svg class="fill-icon">
                                <use></use>
                            </svg>
                            <span>التبرعات</span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <a href="" class="sidebar-link sidebar-title">
                            <svg class="fill-icon">
                                <use></use>
                            </svg>
                            <span>المقابر</span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <a href="" class="sidebar-link sidebar-title">
                            <svg class="fill-icon">
                                <use></use>
                            </svg>
                            <span>الأفراح</span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <a href="#" class="sidebar-link sidebar-title">
                            <svg class="fill-icon">
                                <use></use>
                            </svg>
                            <span>التقارير</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li>
                                <a href="">الإشتراكات</a>
                            </li>
                            <li>
                                <a href="">السكن</a>
                            </li>
                            <li>
                                <a href="">السن</a>
                            </li>
                            <li>
                                <a href="">الوظائف</a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-list">
                        <a href="" class="sidebar-link sidebar-title">
                            <svg class="fill-icon">
                                <use></use>
                            </svg>
                            <span>سجل تسجيل الدخول</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
