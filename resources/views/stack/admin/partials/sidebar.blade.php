

@php
  $user = auth()->user()->userrole;
  $data = App\Models\Rolepermission::where('role_id', '=', $user )->pluck('permission')->unique();
 // dd($user,$data);
@endphp
    <!-- BEGIN: Main Menu-->
    <!-- main menu-->
    <div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
        <!-- main menu header-->
        <!-- / main menu header-->
        <!-- main menu content-->
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <li class=" nav-item"><a href="../../../html/ltr/vertical-modern-menu-template/index.html"><i class="feather icon-home"></i><span class="menu-title" data-i18n="">Dashboard</span><span class="badge badge badge-primary badge-pill float-right">5</span></a>
                </li>
                <li class=" nav-item"><a href="#"><i class="feather icon-zap"></i><span class="menu-title" data-i18n="">Starter kit</span></a>
                    <ul class="menu-content">
                        <li><a class="menu-item" href="layout-1-column.html" data-i18n="nav.starter_kit.1_column">1 column</a>
                        </li>
                        <li><a class="menu-item" href="layout-2-columns.html" data-i18n="nav.starter_kit.2_columns">2 columns</a>
                        </li>
                        <li><a class="menu-item" href="#" data-i18n="nav.starter_kit.3_columns_detached.main">Content Det. Sidebar</a>
                            <ul class="menu-content">
                                <li><a class="menu-item" href="layout-content-detached-left-sidebar.html" data-i18n="nav.starter_kit.3_columns_detached.3_columns_detached_left_sidebar">Detached left sidebar</a>
                                </li>
                                <li><a class="menu-item" href="layout-content-detached-left-sticky-sidebar.html" data-i18n="nav.starter_kit.3_columns_detached.3_columns_detached_sticky_left_sidebar">Detached sticky left sidebar</a>
                                </li>
                                <li><a class="menu-item" href="layout-content-detached-right-sidebar.html" data-i18n="nav.starter_kit.3_columns_detached.3_columns_detached_right_sidebar">Detached right sidebar</a>
                                </li>
                                <li><a class="menu-item" href="layout-content-detached-right-sticky-sidebar.html" data-i18n="nav.starter_kit.3_columns_detached.3_columns_detached_sticky_right_sidebar">Detached sticky right sidebar</a>
                                </li>
                            </ul>
                        </li>
                        <li class="navigation-divider"></li>
                        <li><a class="menu-item" href="layout-fixed-navbar.html" data-i18n="nav.starter_kit.fixed_navbar">Fixed navbar</a>
                        </li>
                        <li><a class="menu-item" href="layout-fixed-navigation.html" data-i18n="nav.starter_kit.fixed_navigation">Fixed navigation</a>
                        </li>
                        <li><a class="menu-item" href="layout-fixed-navbar-navigation.html" data-i18n="nav.starter_kit.fixed_navbar_navigation">Fixed navbar &amp; navigation</a>
                        </li>
                        <li><a class="menu-item" href="layout-fixed-navbar-footer.html" data-i18n="nav.starter_kit.fixed_navbar_footer">Fixed navbar &amp; footer</a>
                        </li>
                        <li class="navigation-divider"></li>
                        <li class="active"><a class="menu-item" href="layout-fixed.html" data-i18n="nav.starter_kit.fixed_layout">Fixed layout</a>
                        </li>
                        <li><a class="menu-item" href="layout-boxed.html" data-i18n="nav.starter_kit.boxed_layout">Boxed layout</a>
                        </li>
                        <li><a class="menu-item" href="layout-static.html" data-i18n="nav.starter_kit.static_layout">Static layout</a>
                        </li>
                        <li class="navigation-divider"></li>
                        <li><a class="menu-item" href="layout-light.html" data-i18n="nav.starter_kit.light_layout">Light layout</a>
                        </li>
                        <li><a class="menu-item" href="layout-dark.html" data-i18n="nav.starter_kit.dark_layout">Dark layout</a>
                        </li>
                        <li><a class="menu-item" href="layout-semi-dark.html" data-i18n="nav.starter_kit.semi_dark_layout">Semi dark layout</a>
                        </li>
                    </ul>
                </li>
                <li class=" nav-item"><a href="https://pixinvent.ticksy.com/" target="_blank"><i class="feather icon-life-buoy"></i><span class="menu-title" data-i18n="">Raise Support</span></a>
                </li>
                <li class=" nav-item"><a href="https://pixinvent.com/stack-bootstrap-admin-template/documentation" target="_blank"><i class="feather icon-folder"></i><span class="menu-title" data-i18n="">Documentation</span></a>
                </li>
            </ul>
        </div>
        <!-- /main menu content-->
        <!-- main menu footer-->
        <!-- main menu footer-->
    </div>
    <!-- / main menu-->
    <!-- END: Main Menu-->