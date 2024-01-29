@php
    $route = Route::current()->getName();
    $currenturl = url()->full();
    $url = parse_url($currenturl, PHP_URL_SCHEME) . '://' . parse_url($currenturl, PHP_URL_HOST) . ':' . parse_url($currenturl, PHP_URL_PORT);
    // echo $currenturl;
    // dd($currenturl);
@endphp
<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item me-auto"><a class="navbar-brand"
                    href="../../../html/rtl/vertical-menu-template/index.html">
                    <span class="brand-logo">

                        <div style="width: 5%">
                            <img class="img-fluid" src="{{ asset('') }}admin/images/pages/reading.png"
                                alt="Login V4" />
                        </div>
                    </span>
                    <h2 style="color:#5E5873" class="brand-text">آل ملحم</h2>
                </a></li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse"><i
                        class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i
                        class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc"
                        data-ticon="disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="{{ $route == 'admin.dashboard' ? 'active' : '' }}"><a class="d-flex align-items-center"
                    href="{{ route('admin.dashboard') }}"><i data-feather="circle"></i><span
                        class="menu-item text-truncate" data-i18n="eCommerce">الرئيسية</span></a>
            </li>
            <li class=" navigation-header"><span data-i18n="Apps &amp; Pages">Apps &amp; Pages</span><i
                    data-feather="more-horizontal"></i>
            </li>
            @can('Index-client')
                <li class="nav-item {{ $route == 'clients.index' ? 'active' : '' }}"><a class="d-flex align-items-center"
                        href="{{ url('admin/clients') }}"><i data-feather='file-text'></i><span
                            class="menu-title text-truncate" data-i18n="Email">الاعضاء</span></a>
                </li>
            @endcan
             @can('Index-welcome_message')
                <li class="nav-item {{ $route == 'welcomeMessages.index' ? 'active' : '' }}"><a class="d-flex align-items-center"
                        href="{{ url('admin/welcomeMessages') }}"><i data-feather='file-text'></i><span
                            class="menu-title text-truncate" data-i18n="Email">الرسائل الترحيبية</span></a>
                </li>
            @endcan
            @can('Index-meeting')
                <li class="nav-item {{ $route == 'meeting.index' ? 'active' : '' }}"><a class="d-flex align-items-center"
                        href="{{ url('admin/meeting') }}"><i data-feather='file-text'></i><span
                            class="menu-title text-truncate" data-i18n="Email">المجالس</span></a>
                </li>
            @endcan
            @can('Index-calender')
                <li class="nav-item {{ $route == 'calender.index' ? 'active' : '' }}"><a class="d-flex align-items-center"
                        href="{{ url('admin/calender') }}"><i data-feather='file-text'></i><span
                            class="menu-title text-truncate" data-i18n="Email">التقويم الاعلامي</span></a>
                </li>
            @endcan
            @if (auth()->user()->can('Index-admin') ||
                    auth()->user()->can('Index-branch') ||
                    auth()->user()->can('Index-driver') ||
                    auth()->user()->can('Index-role') ||
                    auth()->user()->can('Index-employee') ||
                    auth()->user()->can('Index-client'))
                <li class=" nav-item "><a class="d-flex align-items-center" href="#"><i
                            data-feather="file-text"></i><span class="menu-title text-truncate"
                            data-i18n="Invoice">ادارة العضويات</span></a>
                    <ul class="menu-content">
                        @can('Index-admin')
                            <li class="nav-item {{ $route == 'admins.index' ? 'active' : '' }}"><a
                                    class="d-flex align-items-center" href="{{ url('admin/admins') }}"><i
                                        data-feather="user-check"></i><span class="menu-title text-truncate"
                                        data-i18n="Email">المديرين</span></a>
                            </li>
                        @endcan


                        @can('Index-role')
                            <li class="nav-item {{ $route == 'roles.index' ? 'active' : '' }}"><a
                                    class="d-flex align-items-center" href="{{ url('admin/roles') }}"><i
                                        data-feather='shield'></i><span class="menu-title text-truncate"
                                        data-i18n="Email">الوظائف</span></a>
                            </li>
                        @endcan

                    </ul>
                </li>
            @endif


            @if (auth()->user()->can('Index-news_category') ||
                    auth()->user()->can('Index-news'))
                <li class=" nav-item "><a class="d-flex align-items-center" href="#"><i
                            data-feather="file-text"></i><span class="menu-title text-truncate"
                            data-i18n="Invoice">الاخبار
                        </span></a>
                    <ul class="menu-content">
                        @can('Index-news_category')
                            <li class="nav-item {{ $route == 'newsCategory.index' ? 'active' : '' }}"><a
                                    class="d-flex align-items-center" href="{{ url('admin/newsCategory') }}"><i
                                        data-feather="user-check"></i><span class="menu-title text-truncate"
                                        data-i18n="Email">اقسام الاخبار</span></a>
                            </li>
                        @endcan


                        @can('Index-news')
                            <li class="nav-item {{ $route == 'news.index' ? 'active' : '' }}"><a
                                    class="d-flex align-items-center" href="{{ url('admin/news') }}"><i
                                        data-feather='shield'></i><span class="menu-title text-truncate"
                                        data-i18n="Email">الاخبار</span></a>
                            </li>
                        @endcan

                    </ul>
                </li>
            @endif
            @if (auth()->user()->can('Index-occasions_category') ||
                    auth()->user()->can('Index-occasions'))
                <li class=" nav-item "><a class="d-flex align-items-center" href="#"><i
                            data-feather="file-text"></i><span class="menu-title text-truncate"
                            data-i18n="Invoice">المناسبات
                        </span></a>
                    <ul class="menu-content">
                        @can('Index-occasions_category')
                            <li class="nav-item {{ $route == 'occasionsCategory.index' ? 'active' : '' }}"><a
                                    class="d-flex align-items-center" href="{{ url('admin/occasionsCategory') }}"><i
                                        data-feather="user-check"></i><span class="menu-title text-truncate"
                                        data-i18n="Email">اقسام المناسبات</span></a>
                            </li>
                        @endcan


                        @can('Index-occasions')
                            <li class="nav-item {{ $route == 'occasions.index' ? 'active' : '' }}"><a
                                    class="d-flex align-items-center" href="{{ url('admin/occasions') }}"><i
                                        data-feather='shield'></i><span class="menu-title text-truncate"
                                        data-i18n="Email">المناسبات</span></a>
                            </li>
                        @endcan

                    </ul>
                </li>
            @endif
            @if (auth()->user()->can('Index-party')
                    ||auth()->user()->can('Index-superior')
                    )
                <li class=" nav-item "><a class="d-flex align-items-center" href="#"><i
                            data-feather="file-text"></i><span class="menu-title text-truncate"
                            data-i18n="Invoice">التفوق العلمي
                        </span></a>
                    <ul class="menu-content">
                        @can('Index-party')
                            <li class="nav-item {{ $route == 'party.index' ? 'active' : '' }}"><a
                                    class="d-flex align-items-center" href="{{ url('admin/party') }}"><i
                                        data-feather="user-check"></i><span class="menu-title text-truncate"
                                        data-i18n="Email"> الحفلات</span></a>
                            </li>
                        @endcan


                        @can('Index-superior')
                            <li class="nav-item {{ $route == 'superior.index' ? 'active' : '' }}"><a
                                    class="d-flex align-items-center" href="{{ url('admin/superior') }}"><i
                                        data-feather='shield'></i><span class="menu-title text-truncate"
                                        data-i18n="Email">التفوق العلمي</span></a>
                            </li>
                        @endcan

                    </ul>
                </li>
            @endif
            @if (auth()->user()->can('Index-volunteering_type') ||
                    auth()->user()->can('Index-volunteering')||auth()->user()->can('Index-volunteering_request'))
                <li class=" nav-item "><a class="d-flex align-items-center" href="#"><i
                            data-feather="file-text"></i><span class="menu-title text-truncate"
                            data-i18n="Invoice">التطوع
                        </span></a>
                    <ul class="menu-content">
                        @can('Index-volunteering_type')
                            <li class="nav-item {{ $route == 'volunteeringTypes.index' ? 'active' : '' }}"><a
                                    class="d-flex align-items-center" href="{{ url('admin/volunteeringTypes') }}"><i
                                        data-feather="user-check"></i><span class="menu-title text-truncate"
                                        data-i18n="Email">انواع التطوع</span></a>
                            </li>
                        @endcan


                        @can('Index-volunteering')
                            <li class="nav-item {{ $route == 'volunteering.index' ? 'active' : '' }}"><a
                                    class="d-flex align-items-center" href="{{ url('admin/volunteering') }}"><i
                                        data-feather='shield'></i><span class="menu-title text-truncate"
                                        data-i18n="Email">المتطوعين</span></a>
                            </li>
                        @endcan
                        @can('Index-volunteering_request')
                            <li class="nav-item {{ $route == 'volunteeringRequest.index' ? 'active' : '' }}"><a
                                    class="d-flex align-items-center" href="{{ url('admin/volunteeringRequest') }}"><i
                                        data-feather='shield'></i><span class="menu-title text-truncate"
                                        data-i18n="Email">طلبات التتطوع</span></a>
                            </li>
                        @endcan

                    </ul>
                </li>
            @endif

            @if (auth()->user()->can('Index-service_type') ||
                    auth()->user()->can('Index-service'))
                <li class=" nav-item "><a class="d-flex align-items-center" href="#"><i
                            data-feather="file-text"></i><span class="menu-title text-truncate"
                            data-i18n="Invoice">الخدمات الانسانية
                        </span></a>
                    <ul class="menu-content">
                        @can('Index-service_type')
                            <li class="nav-item {{ $route == 'serviceType.index' ? 'active' : '' }}"><a
                                    class="d-flex align-items-center" href="{{ url('admin/serviceType') }}"><i
                                        data-feather="user-check"></i><span class="menu-title text-truncate"
                                        data-i18n="Email">انواع الخدمات الانسانية</span></a>
                            </li>
                        @endcan


                        @can('Index-service')
                            <li class="nav-item {{ $route == 'service.index' ? 'active' : '' }}"><a
                                    class="d-flex align-items-center" href="{{ url('admin/service') }}"><i
                                        data-feather='shield'></i><span class="menu-title text-truncate"
                                        data-i18n="Email">الخدمات الانسانية</span></a>
                            </li>
                        @endcan

                    </ul>
                </li>
            @endif

            @can('Index-notification')
                <li class="nav-item {{ $route == 'notifications.index' ? 'active' : '' }}"><a class="d-flex align-items-center"
                                                                                        href="{{ url('admin/notifications') }}"><i data-feather='file-text'></i><span
                            class="menu-title text-truncate" data-i18n="Email">الاشعارات</span></a>
                </li>
            @endcan

            @can('Index-setting')
                <li class="nav-item {{ $route == 'setting.index' ? 'active' : '' }}"><a class="d-flex align-items-center"
                        href="{{ url('admin/setting') }}"><i data-feather='settings'></i><span
                            class="menu-title text-truncate" data-i18n="Email">الاعدادات</span></a>
                </li>
            @endcan


        </ul>

    </div>
</div>
<!-- END: Main Menu-->
