<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Stack admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, stack admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="userid" content="{{ Auth::check() ? Auth::user()->id : '' }}">

    <title>TagPay</title>
  
    @include('stack.layouts.admin.stylesheets')
    @yield('styles')
</head>

<body class="vertical-layout vertical-menu-modern 2-columns   fixed-navbar" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
    
@include('stack.admin.partials.navbar')

 
        @include('stack.admin.partials.sidebar')
     
        <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>

            @yield('content') 

        </div>
        </div>
      

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>
  @include('stack.admin.partials.footer')

@include('stack.layouts.admin.scripts')
@include('sweetalert::alert')


@yield('scripts')
</body>
</html>