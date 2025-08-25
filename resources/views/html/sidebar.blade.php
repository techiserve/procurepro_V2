@php
    $user = auth()->user()->userrole;
    $data = App\Models\Rolepermission::where('role_id', '=', $user)->pluck('permission')->unique();
@endphp

<div class="menu-right">
    <div class="menu-right__top">
        <div class="logo-right">
            <a href="#"><img src="{{ asset('assets/img/zarq-Logo-black.png') }} " alt="" /></a>
        </div>
        <button class="toggle-btn"><i class="icon-2"></i></button>
    </div>

    <div class="menu-right__search">
        <input type="text" placeholder="Search........" />
        <div class="btn-search"><i class="icon-3"></i></div>
    </div>

    <div class="menu-right__nav">
        <ul class="nav-right">
            {{-- Dashboard --}}
            <li class="active">
                <a href="/home"><i class="icon-4"></i> <span>Dashboard</span></a>
            </li>

            {{-- Master Pages --}}
            @if($user == 3 || $user == 2 || $data->contains('Master Pages'))
                <li>
                    <a href="#"><i class="icon-5"></i> <span>Master Pages</span></a>
                    <ul class="nav-right__sub">
                        <li><a href="/master/manageRole">Manage Roles</a></li>
                        <li><a href="/master/departments">Departments</a></li>
                        <li><a href="/classifications/create">Classification of Expense</a></li>
                        <li><a href="/master/banks">Manage Banks</a></li>
                        <li><a href="/master/bankAccount">Bank Accounts</a></li>
                    </ul>
                </li>
            @endif

            {{-- Users --}}
            @if($user == 3 || $user == 2 || $data->contains('Add New User') || $data->contains('Manage Users'))
                <li>
                    <a href="#"><i class="icon-7"></i> <span>Users</span></a>
                    <ul class="nav-right__sub">
                        @if($user == 3 || $user == 2 || $data->contains('Add New User'))
                            <li><a href="/users/create">Add New User</a></li>
                        @endif
                        @if($user == 3 || $user == 2 || $data->contains('Manage Users'))
                            <li><a href="/users/index">Manage Users</a></li>
                        @endif
                    </ul>
                </li>
            @endif

            {{-- Vendor Management --}}
            @if($user == 3 || $user == 2 || 
                $data->contains('Request a Vendor') || 
                $data->contains('Pending Requests') || 
                $data->contains('All Vendors') || 
                $data->contains('My Requests') || 
                $data->contains('Vendor Type'))
                <li>
                    <a href="#"><i class="icon-6"></i> <span>Vendor Management</span></a>
                    <ul class="nav-right__sub">
                        @if($user == 3 || $user == 2 || $data->contains('Request a Vendor'))
                            <li><a href="/procurement/createVendor">Request a Vendor</a></li>
                        @endif
                        @if($user == 3 || $user == 2 || $data->contains('Vendor Type'))
                            <li><a href="/vendor-types/">Vendor Type</a></li>
                        @endif
                        @if($user == 3 || $user == 2 || $data->contains('All Vendors'))
                            <li><a href="/vendors/index">All Vendors</a></li>
                        @endif
                        @if($user == 3 || $user == 2 || $data->contains('Pending Requests'))
                            <li><a href="/vendors/approval">Pending Requests</a></li>
                        @endif
                        @if($user == 3 || $user == 2 || $data->contains('My Requests'))
                            <li><a href="/vendors/myrequest">My Requests</a></li>
                        @endif
                    </ul>
                </li>
            @endif

            {{-- Procurement --}}
            @if($user == 3 || $user == 2 || 
                $data->contains('Create Purchase Requistion') || 
                $data->contains('View Requisitions') || 
                $data->contains('View Purchase Orders') || 
                $data->contains('Manage Purchase Orders'))
                <li>
                    <a href="#"><i class="icon-8"></i> <span>Procurement</span></a>
                    <ul class="nav-right__sub">
                        @if($user == 3 || $user == 2 || $data->contains('Create Purchase Requistion'))
                            <li><a href="/procurement/createrequisition">New Requisition</a></li>
                        @endif
                        @if($user == 3 || $user == 2 || $data->contains('View Requisitions'))
                            <li><a href="/procurement/indexrequisition">View Requisitions</a></li>
                            <li><a href="/procurement/myrequisition">Pending Requisitions</a></li>
                        @endif
                        @if($user == 3 || $user == 2 || $data->contains('View Purchase Orders'))
                            <li><a href="/procurement/indexpurchaseorder">Purchase Orders</a></li>
                            <li><a href="/procurement/mypurchaseorder">Pending Purchase Orders</a></li>
                            <li><a href="/procurement/managepurchaseorder">Manage Purchase Orders</a></li>
                        @endif
                    </ul>
                </li>
            @endif

            {{-- Reports --}}
            @if($user == 3 || $user == 2 || $data->contains('Reports'))
                <li>
                    <a href="#"><i class="icon-9"></i> <span>Reports</span></a>
                    <ul class="nav-right__sub">
                        <li><a href="/reports/requisitionreport">Purchase Req Summary</a></li>
                        <li><a href="/reports/purchaseorderreport">Purchase Order Summary</a></li>
                        <li><a href="/reports/fnb">FNB</a></li>
                        <li><a href="/reports/albarak">Al Baraka</a></li>
                        <li><a href="/reports/standardbank">Standard Bank</a></li>
                        <li><a href="/reports">Custom Reports</a></li>
                        <li><a href="/reports/spendoverview">Spend Overview Reports</a></li>
                    </ul>
                </li>
            @endif

            {{-- Company (Admin only) --}}
            @if($user == 1)
                <li>
                    <a href="#"><i class="icon-11"></i> <span>Company</span></a>
                    <ul class="nav-right__sub">
                        <li><a href="/companies/create">Add New Company</a></li>
                        <li><a href="/companies/index">Manage Companies</a></li>
                    </ul>
                </li>

                {{-- Executive --}}
                <li>
                    <a href="#"><i class="icon-15"></i> <span>Executive</span></a>
                    <ul class="nav-right__sub">
                        <li><a href="/executives/create">Add New Executive</a></li>
                        <li><a href="/executives/index">Manage Executives</a></li>
                    </ul>
                </li>
            @endif

            {{-- Logout --}}
            <li>
                <a href="{{ route('logout') }}" 
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="icon-13"></i> <span>Logout</span>
                </a>
            </li>
        </ul>
    </div>

    {{-- User Profile --}}
    <div class="user-profile">
        <div class="user-profile__img">
            <img src="{{ asset('/coreui/img/avatars/6.jpg') }}" alt="" />
        </div>
        <h3>{{ auth()->user()->name ?? 'User' }}</h3>
            <a href="{{ route('logout') }}"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();">  </a>
        <button class="btn-user-profile"><i class="icon-10"></i></button>
    </div>

    {{-- Light/Dark Mode Toggle --}}
    <div class="light-dark-toggle-button">
        <input type="checkbox" class="checkbox" id="checkbox" />
        <label for="checkbox" class="checkbox-label">
            <span class="icon-text"><i class="icon-14"></i> Light</span>
            <span class="icon-text"><i class="icon-12"></i> Dark</span>
            <span class="ball"></span>
        </label>
    </div>

    {{-- Logout Form --}}
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</div>
