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
                <li class=" nav-item"><a href="/home"><i class="feather icon-home"></i><span class="menu-title" data-i18n="">Dashboard</span></a>
                </li>
                @if(auth()->user()->userrole == 3 OR auth()->user()->userrole == 2 OR $data->contains('Master Pages'))
                <li class="nav-item">
                    <a href="#"><i class="feather icon-zap"></i><span class="menu-title" data-i18n="">Master Pages</span></a>
                    <ul class="menu-content">
                        <li>
                            <a class="menu-item" href="/master/manageRole" data-i18n="nav.starter_kit.1_column">
                                <i class="nav-icon icon-user-following"></i> Manage Roles
                            </a>
                        </li>
                        <li>
                            <a class="menu-item" href="/master/departments" data-i18n="nav.starter_kit.2_columns">
                                <i class="nav-icon icon-user-follow"></i> Departments
                            </a>
                        </li>
                        <!-- Uncomment if needed
                        <li>
                            <a class="menu-item" href="/master/banks" data-i18n="nav.starter_kit.3_columns">
                                <i class="nav-icon icon-user-following"></i> Manage Banks
                            </a>
                        </li>
                        <li>
                            <a class="menu-item" href="/master/bankAccount" data-i18n="nav.starter_kit.4_columns">
                                <i class="nav-icon icon-user-follow"></i> Bank Accounts
                            </a>
                        </li>
                        -->
                    </ul>
                </li>
            @endif


            @if(auth()->user()->userrole == 3 OR auth()->user()->userrole == 2 OR $data->contains('Add New User') OR $data->contains('Manage Users'))
                <li class="nav-item">
                    <a href="#"><i class="feather icon-airplay"></i><span class="menu-title" data-i18n="">Users</span></a>
                    <ul class="menu-content">
                        @if(auth()->user()->userrole == 3 OR auth()->user()->userrole == 2 OR $data->contains('Add New User'))
                            <li>
                                <a class="menu-item" href="/users/create" data-i18n="nav.starter_kit.1_column">
                                    <i class="nav-icon icon-check"></i> Add New User
                                </a>
                            </li>
                        @endif

                        @if(auth()->user()->userrole == 3 OR auth()->user()->userrole == 2 OR $data->contains('Manage Users'))
                            <li>
                                <a class="menu-item" href="/users/index" data-i18n="nav.starter_kit.2_columns">
                                    <i class="nav-icon icon-cloud-upload"></i> Manage Users
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif


                @if(auth()->user()->userrole == 3 OR auth()->user()->userrole == 2 OR $data->contains('Create Purchase Requistion') OR $data->contains('View Requisitions') OR $data->contains('View Purchase Orders') OR $data->contains('Manage Purchase Orders'))
                <li class=" nav-item"><a href="#"><i class="feather icon-image"></i><span class="menu-title" data-i18n="">Procurement</span></a>
                    <ul class="menu-content">
                    @if( auth()->user()->userrole == 3 OR auth()->user()->userrole == 2 OR $data->contains('Create Purchase Requistion'))
                        <li><a class="menu-item" href="/procurement/createrequisition" data-i18n="nav.starter_kit.1_column">New Requisition</a>
                        </li>
                        @endif

                        @if( auth()->user()->userrole == 3 OR auth()->user()->userrole == 2 OR $data->contains('View Requisitions'))
                        <li><a class="menu-item" href="/procurement/indexrequisition" data-i18n="nav.starter_kit.2_columns">View Requisitions</a>
                        </li>  
                       @endif

                        @if( auth()->user()->userrole == 3 OR auth()->user()->userrole == 2 OR $data->contains('View Requisitions'))
                        <li><a class="menu-item" href="/procurement/myrequisition" data-i18n="nav.starter_kit.2_columns">Pending Requisition Approvals</a>
                        </li> 
                        @endif

                        @if( auth()->user()->userrole == 3 OR auth()->user()->userrole == 2 OR $data->contains('View Purchase Orders'))
                        <li><a class="menu-item" href="/procurement/indexpurchaseorder" data-i18n="nav.starter_kit.2_columns">Purchase Orders</a>
                        </li> 
                        @endif

                        @if( auth()->user()->userrole == 3 OR auth()->user()->userrole == 2 OR $data->contains('View Purchase Orders'))
                        <li><a class="menu-item" href="/procurement/mypurchaseorder" data-i18n="nav.starter_kit.2_columns">Pending Purchase Order Approvals</a>
                        </li> 
                        @endif

                        @if( auth()->user()->userrole == 3 OR auth()->user()->userrole == 2 OR $data->contains('View Purchase Orders'))
                        <li><a class="menu-item" href="/procurement/managepurchaseorder" data-i18n="nav.starter_kit.2_columns">Manage Purchase Orders</a>
                        </li> 
                        @endif                   
                    </ul>
                </li>
                @endif



                @if(auth()->user()->userrole == 3 OR auth()->user()->userrole == 2 OR $data->contains('Reports'))
                <li class="nav-item">
                    <a href="#"><i class="feather icon-briefcase"></i><span class="menu-title" data-i18n="">Reports</span></a>
                    <ul class="menu-content">
                        <li>
                            <a class="menu-item" href="/reports/requisitionreport" data-i18n="nav.starter_kit.1_column">
                                 Purchase Requisition Summary
                            </a>
                        </li>
                        <li>
                            <a class="menu-item" href="/reports/purchaseorderreport" data-i18n="nav.starter_kit.2_columns">
                                Purchase Order Summary
                            </a>
                        </li>
                        <!-- Uncomment if needed
                        <li>
                            <a class="menu-item" href="/reports/waitingpurchaseorder" data-i18n="nav.starter_kit.3_columns">
                                <i class="nav-icon icon-check"></i> Purchase Orders Awaiting Payment
                            </a>
                        </li>
                        -->
                    </ul>
                </li>
            @endif



            @if(auth()->user()->userrole == 1)
                <!-- COMPANY -->
                <li class="nav-item">
                    <a href="#"><i class="feather icon-plus-square"></i><span class="menu-title" data-i18n="">Company</span></a>
                    <ul class="menu-content">
                        <li>
                            <a class="menu-item" href="/companies/create" data-i18n="nav.starter_kit.1_column">
                                <i class="nav-icon icon-check"></i> Add New Company
                            </a>
                        </li>
                        <li>
                            <a class="menu-item" href="/companies/index" data-i18n="nav.starter_kit.2_columns">
                                <i class="nav-icon icon-cloud-upload"></i> Manage Companies
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- EXECUTIVE -->
                <li class="nav-item">
                    <a href="#"><i class="feather icon-image"></i><span class="menu-title" data-i18n="">Executive</span></a>
                    <ul class="menu-content">
                        <li>
                            <a class="menu-item" href="/executives/create" data-i18n="nav.starter_kit.1_column">
                                <i class="nav-icon icon-check"></i> Add New Executive
                            </a>
                        </li>
                        <li>
                            <a class="menu-item" href="/executives/index" data-i18n="nav.starter_kit.2_columns">
                                <i class="nav-icon icon-cloud-upload"></i> Manage Executives
                            </a>
                        </li>
                    </ul>
                </li>
            @endif

                <li class=" nav-item"><a href="#" target="_blank"><span class="menu-title" data-i18n=""><bold>TAGPAY - SIGNOUT</bold></span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                    <i class="nav-icon icon-lock-open"></i> {{ __('Logout') }}
                    </a>
                </li>
            </ul>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
   
        </div>
        <!-- /main menu content-->
        <!-- main menu footer-->
        <!-- main menu footer-->
    </div>
    <!-- / main menu-->
    <!-- END: Main Menu-->