    <!-- BEGIN: Header-->
    <nav class="header-navbar navbar-expand-lg navbar navbar-with-menu fixed-top navbar-semi-dark">
        <div class="navbar-wrapper">
            <div class="navbar-header">
                <ul class="nav navbar-nav flex-row">
                    <li class="nav-item mobile-menu d-lg-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="feather icon-menu font-large-1"></i></a></li>
                    <li class="nav-item mr-auto"><a class="navbar-brand" href="../../../html/ltr/vertical-modern-menu-template/index.html">
                            <h2 class="brand-text">TagPay</h2>
                        </a></li>
                    <li class="nav-item d-lg-none"><a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="fa fa-ellipsis-v"></i></a></li>
                </ul>
            </div>
            <div class="navbar-container content">
                <div class="collapse navbar-collapse" id="navbar-mobile">
                    <ul class="nav navbar-nav float-right ml-auto">
                        <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                                <div class="avatar avatar-online"><img src="{{ asset('/coreui/img/avatars/6.jpg') }}" alt="avatar"><i></i></div><span class="user-name"> {{ Auth::user()->name }}</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="/profile/{{Auth::user()->id}}"><i class="feather icon-user"></i> Edit Profile</a><a class="dropdown-item" href="{{ route('logout') }}"    onclick="event.preventDefault();
              document.getElementById('logout-form').submit();">
                   <i class="feather icon-power"></i> Logout</a>  
                            </div>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
          </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
   <!-- END: Header-->