@php
    $user = Auth::user();
@endphp
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
        <div class="logo-icon-wrapper text-center mt-3 w-lg-100 p-0" style="width: 100px">
            <a href={{route('home')}}>
                <img class="img-fluid me-0" src="{{ asset('assets/images/logo/لوجو الجمعية.png') }}" width="70" alt="Logo">
            </a>
        </div>
        <nav class="sidebar-main">
            <div id="sidebar-menu">
                <ul class="sidebar-links w-100" id="simple-bar">
                    @can('لوحة التحكم')
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title" href="{{ route('home') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                                </svg>
                                <span>لوحة التحكم</span>
                            </a>
                        </li>
                    @endcan
                    @can('الاخبار')
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title" href="{{route('news.all')}}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-form') }}"></use>
                                </svg>
                                <span>الأخبار</span>
                            </a>
                        </li>
                    @endcan
                    @can('المشتركين')
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title" href="{{route('subscriber.all')}}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#fill-user') }}"></use>
                                </svg>
                                <span>المشتركين</span>
                            </a>
                        </li>
                    @endcan
                    @can('الإشتراك السنوي')
                        <li class="sidebar-list">
                            <a href="{{route('costyears.all')}}" class="sidebar-link sidebar-title">
                                <i class="fa-duotone fa-rings-wedding text-muted fs-5"></i>
                                <span>الإشتراك السنوي</span>
                            </a>
                        </li>
                    @endcan
                    @can('النثريات')
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title" href="{{route('miscellaneous.all')}}">
                                <i class="fa-solid fa-file-invoice fs-5 text-muted"></i>
                                <span>النثريات</span>
                            </a>
                        </li>
                    @endcan
                    @can('مجلس الادارة')
                        <li class="sidebar-list">
                            <a href="{{route('board.all')}}" class="sidebar-link sidebar-title">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#fill-user') }}"></use>
                                </svg>
                                <span>مجلس الإدارة</span>
                            </a>
                        </li>
                    @endcan
                    @can('اللجان')
                        <li class="sidebar-list">
                            <a href="{{route('association.all')}}" class="sidebar-link sidebar-title">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                                </svg>
                                <span>لجان الجمعية</span>
                            </a>
                        </li>
                    @endcan
                    @can('الحرفيين')
                        <li class="sidebar-list">
                            <a href="{{route('workers.all')}}" class="sidebar-link sidebar-title">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#fill-user') }}"></use>
                                </svg>
                                <span>حرفيين</span>
                            </a>
                        </li>
                    @endcan
                    @can('التبرعات الخارجية')
                        <li class="sidebar-list">
                            <a href="{{route('donators.all')}}" class="sidebar-link sidebar-title">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#profit') }}"></use>
                                </svg>
                                <span>التبرعات الخارجية</span>
                            </a>
                        </li>
                    @endcan
                    @can('المقابر')
                        <li class="sidebar-list">
                            <a href="{{route('tomb.all')}}" class="sidebar-link sidebar-title">
                                <i class="fa-solid fa-tombstone-blank text-muted fs-5"></i>
                                <span>المقابر</span>
                            </a>
                        </li>
                    @endcan
                    @can('الافراح')
                        <li class="sidebar-list">
                            <a href="{{route('weddings.all')}}" class="sidebar-link sidebar-title">
                                <i class="fa-duotone fa-rings-wedding text-muted fs-5"></i>
                                <span>مواعيد الأفراح</span>
                            </a>
                        </li>
                    @endcan
                    @can('التقارير')
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
                                        <span>الإشتراكات</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('reports.location')}}">
                                        <span>السكن</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('reports.age')}}">
                                        <span>السن</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('reports.jobs')}}">
                                        <span>الوظائف</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('reports.donations')}}">
                                        <span>التبرعات الخارجية</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('reports.innerDonations')}}">
                                        <span>التبرعات الداخلية</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('reports.search')}}">
                                        <span>متأخرات الإشتراكات</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('reports.associates')}}">
                                        <span>المنتسبين</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('reports.subscribersData')}}">
                                        <span>بيانات الاعضاء المحدثة</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('reports.incompete')}}">
                                        <span>البيانات الغير مكتمله</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('reports.safe')}}">
                                        <span>الخزنة</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('bankTransactios')}}">
                                        <span>البنك</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endcan
                    @if($user->hasRole('master'))
                        <li class="sidebar-list">
                            <a href="#" class="sidebar-link sidebar-title">
                                <i class="fa-duotone fa-rings-wedding text-muted fs-5"></i>
                                <span>المستخدمين</span>
                            </a>
                            <ul class="sidebar-submenu">
                                <li>
                                    <a href="{{route('user.index')}}">
                                        <span>المستخدمين</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('roles.index')}}">
                                        <span>الأدوار</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('permissions.index')}}">
                                        <span>الصلاحيات</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-list">
                            <a href="{{route('activity.index')}}" class="sidebar-link sidebar-title">
                                <i data-feather="log-in" class="text-white"></i>
                                <span>سجل النشاطات</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </nav>
    </div>
</div>
