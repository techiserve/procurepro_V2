<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ZARQ</title>

    <link rel="icon" href="{{ asset('assets/img/favicon.ico') }}" type="image/x-icon" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/slick.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />

    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />

    <style>
      /* Ensure the dropdown isn't clipped by header wrappers */
      .page-header, .header-right { overflow: visible !important; }

      /* Container */
      .user-dropdown { position: relative; z-index: 2000; }

      /* Toggle */
      .user-dropdown__image {
        display: flex; align-items: center; gap: 8px;
        cursor: pointer; user-select: none;
      }
      .user-dropdown__image img { width: 28px; height: 28px; border-radius: 50%; object-fit: cover; }
      .user-dropdown__image .caret { opacity: .7; }

      /* Menu */
      .user-dropdown__menu {
        position: absolute; top: calc(100% + 8px); right: 0;
        min-width: 180px; list-style: none; margin: 0; padding: 6px 0;
        background: #fff; border: 1px solid #e6e6e6; border-radius: 8px;
        box-shadow: 0 8px 24px rgba(0,0,0,.08);
        display: none;
      }
      .user-dropdown.open .user-dropdown__menu { display: block; }

      .user-dropdown__menu a,
      .user-dropdown__menu button {
        display: block; width: 100%;
        padding: 8px 12px; text-align: left;
        background: none; border: 0; color: inherit; text-decoration: none; cursor: pointer;
      }
      .user-dropdown__menu a:hover,
      .user-dropdown__menu button:hover { background: #f5f5f5; }

      .user-dropdown__divider { border: 0; border-top: 1px solid #eee; margin: 6px 0; }

      /* ===== Cards safety: make sure text is above decorative image ===== */
      .requisition-requested { position: relative; overflow: visible; }
      .requisition-requested-item { position: relative; }
      .requisition-requested-item__wrapper { position: relative; }
      .requisition-requested-item__content { position: relative; z-index: 2; }
      .requisition-requested-item__image { position: relative; z-index: 1; pointer-events: none; }

      /* If your theme uses absolute positioning for the image, uncomment:
      .requisition-requested-item__image { position: absolute; right: 0; bottom: 0; z-index: 1; pointer-events: none; }
      */
    </style>
</head>

<body>
@php
    $user = auth()->user()->userrole;
    $data = App\Models\Rolepermission::where('role_id', '=', $user)->pluck('permission')->unique();
@endphp

<div class="menu-right">
  <div class="menu-right__top">
    <div class="logo-right">
      <a href="#"><img src="{{ asset('assets/img/zarq-Logo-black.png') }}" alt="ZARQ Logo" /></a>
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
          $data->contains('Create Purchase Requisition') || 
          $data->contains('View Requisitions') || 
          $data->contains('View Purchase Orders') || 
          $data->contains('Manage Purchase Orders'))
        <li>
          <a href="#"><i class="icon-8"></i> <span>Procurement</span></a>
          <ul class="nav-right__sub">
            @if($user == 3 || $user == 2 || $data->contains('Create Purchase Requisition'))
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
            <li><a href="/itemizedreports">Itemized Custom Reports</a></li>
            <li><a href="/dashboard/procurement">Spend Overview Reports</a></li>
            <li><a href="/reports/procureprorequisition">ProcurePro Requisition</a></li>
            <li><a href="/reports/procurepropurchaseorder">ProcurePro Purchase Order</a></li>
          </ul>
        </li>
      @endif

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

      {{-- Logout (link triggers the hidden form below) --}}
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
      <img src="{{ asset('/coreui/img/avatars/6.jpg') }}" alt="User Avatar" />
    </div>
    <h3>{{ auth()->user()->name ?? 'User' }}</h3>
    {{-- Logout button (keeps classes) --}}
    <button type="button" class="btn-user-profile" title="Logout"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
      <i class="icon-10"></i>
    </button>
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

  {{-- Single hidden logout form (avoid duplicate IDs) --}}
  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
  </form>
</div>

<div class="body-section">
  <div class="page-header">
    <button class="toggle-btn dextop"><i class="icon-2"></i></button>
    <div class="header-right">
      <div class="user-dropdown" id="userDropdown">
        <div class="user-dropdown__image" id="userDropdownToggle" role="button" tabindex="0" aria-haspopup="true" aria-expanded="false">
          {{-- NOTE: fix the image extension if needed (.png) --}}
          <img src="{{ asset('assets/img/user-dropdown__image.png') }}" alt="User" />
          <p class="m-0">{{ Auth::user()->name }}</p>
          <svg class="caret" width="12" height="8" viewBox="0 0 12 8" aria-hidden="true"><path d="M1 1l5 5 5-5" fill="none" stroke="currentColor" stroke-width="2"/></svg>
        </div>

        <ul class="user-dropdown__menu" id="userDropdownMenu">
          <li><a href="/profile/{{ Auth::user()->id }}">Edit Profile</a></li>
          <li><hr class="user-dropdown__divider"></li>
          <li>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit">Logout</button>
            </form>
          </li>
        </ul>
      </div>
    </div>
    <div class="toggle-btn">
      <div class="one"></div>
      <div class="two"></div>
      <div class="three"></div>
    </div>
  </div>

  <div class="body-content bg-transparent">
    <div class="body-content__wrapper">
      <div class="requisition-requested">

        {{-- Card 1 — fixed: uses asset() and forces content above image --}}
        <div class="requisition-requested-item">
          <div class="requisition-requested-item__wrapper">
            <div class="requisition-requested-item__content">
              <h3>Requisition Requested.</h3>
              <h4>{{ $requisitions }}</h4>
              <ul></ul>
            </div>
            <div class="requisition-requested-item__image">
              <img src="{{ asset('assets/img/requisition-requested-img.png') }}" alt="Requisition Requested" />
            </div>
          </div>
        </div>

        {{-- Card 2 --}}
        <div class="requisition-requested-item">
          <div class="requisition-requested-item__wrapper">
            <div class="requisition-requested-item__content">
              <h3>Pending Requisitions</h3>
              <h4>{{ $departments }}</h4>
              <ul></ul>
            </div>
            <div class="requisition-requested-item__image">
              <img src="{{ asset('assets/img/requisition-requested-img2.png') }}" alt="Pending Requisitions" />
            </div>
          </div>
        </div>

        {{-- Card 3 --}}
        <div class="requisition-requested-item">
          <div class="requisition-requested-item__wrapper">
            <div class="requisition-requested-item__content">
              <h3>Purchase orders</h3>
              <h4>{{ $purchaseorders }}</h4>
              <ul></ul>
            </div>
            <div class="requisition-requested-item__image">
              <img src="{{ asset('assets/img/requisition-requested-img3.png') }}" alt="Purchase Orders" />
            </div>
          </div>
        </div>

        {{-- Card 4 --}}
        <div class="requisition-requested-item">
          <div class="requisition-requested-item__wrapper">
            <div class="requisition-requested-item__content">
              <h3>Pending  Purchase Orders</h3>
              <h4>{{ $userCount }}</h4>
              <ul></ul>
            </div>
            <div class="requisition-requested-item__image">
              <img src="{{ asset('assets/img/requisition-requested-img4.png') }}" alt="Pending Purchase Orders" />
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/slick.min.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const wrap   = document.getElementById('userDropdown');
    const toggle = document.getElementById('userDropdownToggle');
    const menu   = document.getElementById('userDropdownMenu');
    if (!wrap || !toggle || !menu) return;

    function openMenu() {
      wrap.classList.add('open');
      toggle.setAttribute('aria-expanded', 'true');
    }
    function closeMenu() {
      wrap.classList.remove('open');
      toggle.setAttribute('aria-expanded', 'false');
    }
    function toggleMenu() {
      wrap.classList.contains('open') ? closeMenu() : openMenu();
    }

    // Toggle on click/keyboard
    toggle.addEventListener('click', function (e) { e.stopPropagation(); toggleMenu(); });
    toggle.addEventListener('keydown', function (e) {
      if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); toggleMenu(); }
      if (e.key === 'Escape') { closeMenu(); }
    });

    // Clicks inside menu shouldn’t close before action
    menu.addEventListener('click', function (e) { e.stopPropagation(); });

    // Click anywhere else closes
    document.addEventListener('click', closeMenu);
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeMenu(); });
  });
</script>

</body>
</html>
