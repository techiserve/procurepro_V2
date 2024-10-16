<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>SmartFarmer</title>
    @include('layouts.admin.meta')
    @include('layouts.admin.stylesheets')
    @yield('styles')
   
</head>
<body class="app flex-row align-items-center">
      

    @yield('content')
    @include('layouts.admin.scripts')
    @yield('scripts')
   
</body>
</html>