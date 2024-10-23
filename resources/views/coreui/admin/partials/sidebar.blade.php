

@php
  $user = auth()->user()->userrole;
  $data = App\Models\Rolepermission::where('role_id', '=', $user )->pluck('permission')->unique();
 // dd($user,$data);
@endphp

<div class="sidebar" style="background-color:#102746">
  <nav class="sidebar-nav">
    <ul class="nav">
      <!-- <li class="nav-item active">
        <a class="nav-link" href="/home">
          <i class="nav-icon icon-speedometer"></i> Dashboard
        </a>
      </li> -->
      <li class="nav-item active">
        <a class="nav-link" href="/home">
          <i class="nav-icon icon-speedometer"></i> Dashboard
        </a>
      </li>
      <!-- <li class="nav-item active">
        <a class="nav-link" href="/profile">
          <i class="nav-icon fa fa-user-secret"></i>Profile
        </a>
      </li> -->
<!-- 
      <li class="nav-item active">
        <a class="nav-link" href="/bone-auth">
          <i class="nav-icon icon-lock"></i> B-One Auth
        </a>
      </li>
   
      <li class="nav-item active">
        <a class="nav-link" href="/seasons">
          <i class="nav-icon icon-calendar"></i> System Seasons
        </a>
      </li> -->
   

      <li class="nav-title">Procure Pro 360 - Modules</li>
      <!-- MANAGE GROWERS -->
      <!-- @if(auth()->user()->userrole == 3 OR auth()->user()->userrole == 2 OR $data->contains('Request New Vendor') OR $data->contains('Pending Requests') OR $data->contains('Manage Vendors') OR $data->contains('My Requests'))
      <li class="nav-item nav-dropdown  active ">
        <a class="nav-link nav-dropdown-toggle" href="#">
          <i class="nav-icon icon-people "></i> Vendors</a>
        <ul class="nav-dropdown-items d-md-down-none">

        @if(auth()->user()->userrole == 3 OR auth()->user()->userrole == 2 OR$data->contains('Request New Vendor'))
          <li class="nav-item active">
            <a class="nav-link" href="/users/show">
              <i class="nav-icon icon-user-following"></i> Request Vendor</a>
          </li>
          @endif


          @if(auth()->user()->userrole == 3 OR auth()->user()->userrole == 2 OR$data->contains('Manage Vendors'))
          <li class="nav-item active">
            <a class="nav-link" href="/growers/create">
              <i class="nav-icon icon-user-follow"></i> Manage Vendor</a>
          </li>
          @endif


          @if(auth()->user()->userrole == 3 OR auth()->user()->userrole == 2 OR$data->contains('Pending Requests'))
          <li class="nav-item active">
            <a class="nav-link" href="/grower/parameters">
              <i class="nav-icon icon-settings"></i> Pending Requests </a>
          </li>
          @endif       

          @if(auth()->user()->userrole == 3 OR auth()->user()->userrole == 2 OR$data->contains('My Requests'))
          <li class="nav-item active">
            <a class="nav-link" href="/grower/parameters">
              <i class="nav-icon icon-settings"></i> My Requests </a>
          </li>
          @endif


        </ul>
      </li>
      @endif -->


      @if(auth()->user()->userrole == 3 OR auth()->user()->userrole == 2 OR $data->contains('Create Purchase Requistion') OR $data->contains('View Requisitions') OR $data->contains('View Purchase Orders') OR $data->contains('Manage Purchase Orders'))
      <!-- RISK MANAGEMENT -->
      <li class="nav-item nav-dropdown active  ">
        <a class="nav-link nav-dropdown-toggle" href="#">
          <i class="nav-icon icon-shuffle"></i>Procurement</a>
        <ul class="nav-dropdown-items">
        @if( auth()->user()->userrole == 3 OR auth()->user()->userrole == 2 OR $data->contains('Create Purchase Requistion'))
          <li class="nav-item active">
            <a class="nav-link" href="/procurement/createrequisition">
              <i class="nav-icon icon-check"></i> New Requisition</a>
          </li>
          @endif

          @if( auth()->user()->userrole == 3 OR auth()->user()->userrole == 2 OR$data->contains('View Requisitions'))
          <li class="nav-item active">
            <a class="nav-link" href="/procurement/indexrequisition">
              <i class="nav-icon icon-cloud-upload"></i> View Requisitions</a>
          </li>
          @endif

          @if( auth()->user()->userrole == 3 OR auth()->user()->userrole == 2 OR$data->contains('View Requisitions'))
          <li class="nav-item active">
            <a class="nav-link" href="/procurement/myrequisition">
              <i class="nav-icon icon-settings"></i>Pending Requisition Approvals</a>
          </li>
          @endif


          @if( auth()->user()->userrole == 3 OR auth()->user()->userrole == 2 OR$data->contains('View Purchase Orders'))
          <li class="nav-item active">
            <a class="nav-link" href="/procurement/indexpurchaseorder">
              <i class="nav-icon icon-settings"></i>Purchase Orders</a>
          </li>
          @endif

          @if( auth()->user()->userrole == 3 OR auth()->user()->userrole == 2 OR$data->contains('View Purchase Orders'))
          <li class="nav-item active">
            <a class="nav-link" href="/procurement/mypurchaseorder">
              <i class="nav-icon icon-settings"></i>Pending Purchase Order Approvals</a>
          </li>
          @endif

   
          @if( auth()->user()->userrole == 3 OR auth()->user()->userrole == 2 OR$data->contains('View Purchase Orders'))
          <li class="nav-item active">
            <a class="nav-link" href="/procurement/managepurchaseorder">
              <i class="nav-icon icon-settings"></i>Manage Purchase Orders</a>
          </li>
          @endif

          <!-- @if( auth()->user()->userrole == 3 OR auth()->user()->userrole == 2 OR$data->contains('Manage Purchase Orders'))
          <li class="nav-item active">
            <a class="nav-link" href="/procurement/approvalpurchaseorder">
              <i class="nav-icon icon-settings"></i>Manage Purchase Orders</a>
          </li>
          @endif -->
        </ul>
      </li>
      @endif


      @if(auth()->user()->userrole == 3 OR auth()->user()->userrole == 2)
             <!-- RISK MANAGEMENT
             <li class="nav-item nav-dropdown active  ">
        <a class="nav-link nav-dropdown-toggle" href="#">
          <i class="nav-icon icon-lock"></i>Settings</a>
        <ul class="nav-dropdown-items">
          <li class="nav-item active">
            <a class="nav-link" href="/risk-management/approve-growers">
              <i class="nav-icon icon-check"></i>Department Management</a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="/risk-management/uploads">
              <i class="nav-icon icon-cloud-upload"></i> Vendor Type</a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="/risk-parameters">
              <i class="nav-icon icon-settings"></i>Manage Roles</a>
          </li>
        </ul>
      </li> -->
      @endif


      @if(auth()->user()->userrole == 1)
             <!-- COMPANY -->
          <li class="nav-item nav-dropdown active  ">
        <a class="nav-link nav-dropdown-toggle" href="#">
          <i class="nav-icon icon-lock"></i>Company</a>
        <ul class="nav-dropdown-items">
          <li class="nav-item active">
            <a class="nav-link" href="/companies/create">
              <i class="nav-icon icon-check"></i>Add New Company</a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="/companies/index">
              <i class="nav-icon icon-cloud-upload"></i>Manage Companies</a>
          </li>
        </ul>
      </li>
      
             <!-- EXECUTIVE -->
             <li class="nav-item nav-dropdown active  ">
        <a class="nav-link nav-dropdown-toggle" href="#">
          <i class="nav-icon icon-lock"></i>Executive</a>
        <ul class="nav-dropdown-items">
          <li class="nav-item active">
            <a class="nav-link" href="/executives/create">
              <i class="nav-icon icon-check"></i>Add New Executive</a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="/executives/index">
              <i class="nav-icon icon-cloud-upload"></i>Manage Executives</a>
          </li>
        </ul>
      </li>
      @endif



      @if(auth()->user()->userrole == 3 OR auth()->user()->userrole == 2 OR $data->contains('Add New User') OR $data->contains('Manage Users'))
       <!-- RISK MANAGEMENT -->
       <li class="nav-item nav-dropdown active  ">
        <a class="nav-link nav-dropdown-toggle" href="#">
          <i class="nav-icon icon-calendar"></i>Users</a>
        <ul class="nav-dropdown-items">
        @if( auth()->user()->userrole == 3 OR auth()->user()->userrole == 2 OR$data->contains('Add New User'))
          <li class="nav-item active">
            <a class="nav-link" href="/users/create">
              <i class="nav-icon icon-check"></i> Add New User</a>
          </li>
          @endif

          @if( auth()->user()->userrole == 3 OR auth()->user()->userrole == 2 OR $data->contains('Manage Users'))
          <li class="nav-item active">
            <a class="nav-link" href="/users/index">
              <i class="nav-icon icon-cloud-upload"></i> Manage Users</a>
          </li>
          @endif
        </ul>
      </li>
      @endif


      @if(auth()->user()->userrole == 3 OR auth()->user()->userrole == 2 OR $data->contains('Master Pages'))
      <li class="nav-item nav-dropdown  active ">
        <a class="nav-link nav-dropdown-toggle" href="#">
          <i class="nav-icon icon-people "></i>Master Pages</a>
        <ul class="nav-dropdown-items d-md-down-none">
          <li class="nav-item active">
            <a class="nav-link" href="/master/manageRole">
              <i class="nav-icon icon-user-following"></i>Manage Roles</a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="/master/departments">
              <i class="nav-icon icon-user-follow"></i>Departments</a>
          </li>
          <!-- <li class="nav-item active">
            <a class="nav-link" href="/master/banks">
              <i class="nav-icon icon-user-following"></i>Manage Banks</a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="/master/bankAccount">
              <i class="nav-icon icon-user-follow"></i> Bank Accounts</a>
          </li>      -->
        </ul>
      </li>
      @endif

      @if(auth()->user()->userrole == 3 OR auth()->user()->userrole == 2 OR $data->contains('Reports'))
      <li class="nav-item nav-dropdown active  ">
        <a class="nav-link nav-dropdown-toggle" href="#">
          <i class="nav-icon icon-settings"></i>Reports</a>
        <ul class="nav-dropdown-items">
  
          <li class="nav-item active">
            <a class="nav-link" href="/reports/requisitionreport">
              <i class="nav-icon icon-cloud-upload"></i> Purchase Requistion Summary</a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="/reports/purchaseorderreport">
              <i class="nav-icon icon-settings"></i>Purchase Order Summary</a>
          </li>
          <!-- <li class="nav-item active">
            <a class="nav-link" href="/reports/waitingpurchaseorder">
              <i class="nav-icon icon-check"></i>Purchase Orders Awaiting Payment</a>
          </li> -->
     
        </ul>
      </li>
      @endif

      
      @if(auth()->user()->userrole == 3 OR auth()->user()->userrole == 2 OR $data->contains('Reports'))
      <!-- <li class="nav-item nav-dropdown active  ">
        <a class="nav-link nav-dropdown-toggle" href="#">
          <i class="nav-icon fa fa-university"></i>Bank Reports</a>
        <ul class="nav-dropdown-items">
          <li class="nav-item active">
            <a class="nav-link" href="/risk-management/approve-growers">
              <i class="nav-icon icon-check"></i>Standard </a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="/risk-management/uploads">
              <i class="nav-icon icon-cloud-upload"></i> AI Baraka </a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="/risk-parameters">
              <i class="nav-icon icon-settings"></i>FNB</a>
          </li>
        </ul>
      </li> -->
      @endif
     
     

      <li class="nav-title">Procure Pro 360 - Signout</li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('logout') }}"
              onclick="event.preventDefault();
              document.getElementById('logout-form').submit();">
          <i class="nav-icon icon-lock-open"></i> {{ __('Logout') }}
        </a>
      </li>
    </ul>
  </nav>
  <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
