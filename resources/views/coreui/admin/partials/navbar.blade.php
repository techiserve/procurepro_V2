<div id="app">
  <header class="app-header navbar">
    <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
      <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#" >
      <!-- <img class="navbar-brand-full" src="{{ asset('coreui/img/brand/logo3.jpg') }}" width="161" height="52" alt="Rift vallley Logo"> -->
      <img class="navbar-brand-full" src="{{ asset('coreui/img/brand/apc.png') }}" width="161" height="52" alt="Rift vallley Logo">
    </a>
    <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
      <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="nav navbar-nav d-md-down-none">
    
      <li class="nav-item px-3">
        <a class="nav-link" href="#">&nbsp;</a>
      </li>
     
    </ul>
     
    <ul class="nav navbar-nav ml-auto">
      <!-- NOTIFICATIONS FOR THE APPLICATION -->
      <notification v-bind:notifications="notifications"></notification>
      <!-- END OF NOTIFICATIONS FOR THE APPLICATION -->
      <li class="nav-item d-md-down-none" >
        {{ Auth::user()->name }}  <b></b>
      </li>
      <li class="nav-item d-md-down-none" >
         <b>|</b>
      </li>
    
      <li class="nav-item d-md-down-none">
      @if(auth()->user()->userrole == 1)
      Super Admin 
      @elseif (auth()->user()->userrole == 2)
      Executive
      @elseif (auth()->user()->userrole == 3)
      Company Admin
      @else 
      @php
     $data = App\Models\userrole::where('id', '=', auth()->user()->userrole )->first()
     @endphp
     {{  $data->name }}
      @endif
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
          <div class="avatar">
            <img class="img-avatar" src="{{ asset('/coreui/img/avatars/6.jpg') }}" alt="{{ Auth::user()->email }}">
           
                <span class="avatar-status badge-success" title="B1 Session Active"></span>
          
          </div>
        </a>
        <div class="dropdown-menu dropdown-menu-right">
          <div class="dropdown-header text-center">
            <strong>Settings</strong>
          </div>
          <!-- <a class="dropdown-item" href="/profile">
            <i class="fa fa-user"></i> Profile
          </a> -->
          {{--<a class="dropdown-item" href="/settings">
            <i class="fa fa-wrench"></i> Settings
          </a>--}}
          <a class="dropdown-item"  href="{{ route('logout') }}"
              onclick="event.preventDefault();
              document.getElementById('logout-form').submit();">
              <i class="fa fa-lock"></i> {{ __('Logout') }}
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
          </form>
        </div>
      </li>
    </ul>
  </header>
</div>
