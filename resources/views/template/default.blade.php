<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Procure Pro 360</title>
    <link rel="icon" type="image/x-icon" href="{!! asset('template/assets/media/photos/logo1.png') !!}"/>
    <!-- ENABLE LOADERS -->
      <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{!! asset('template/plugins/fontawesome-free/css/all.min.css') !!}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{!! asset('template/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') !!}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{!! asset('template/plugins/icheck-bootstrap/icheck-bootstrap.min.css') !!}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{!! asset('template/plugins/jqvmap/jqvmap.min.css') !!}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{!! asset('template/dist/css/adminlte.min.css') !!}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{!! asset('template/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') !!}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{!! asset('template/plugins/daterangepicker/daterangepicker.css') !!}">
  <!-- summernote -->
  <link rel="stylesheet" href="{!! asset('template/plugins/summernote/summernote-bs4.min.css') !!}">

  <link rel="stylesheet" href="{!! asset('template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') !!}">

  <link rel="stylesheet" href="{!! asset('template/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') !!}">

  <link rel="stylesheet" href="{!! asset('template/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') !!}">
    
</head>
<body class="hold-transition sidebar-mini layout-fixed">

<div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{!! asset('template/assets/media/photos/logo1.png') !!}" alt="AdminLTELogo" height="60" width="60">
  </div>

    <!--  BEGIN NAVBAR  -->
       @include('template.navbar')
    <!--  END NAVBAR  -->

        <!--  BEGIN SIDEBAR  -->
      @include('template.sidebar')
        <!--  END SIDEBAR  -->
        <div class="content-wrapper">    
        <!--  BEGIN CONTENT AREA  -->
      @yield('content')
        <!--  END CONTENT AREA  -->
       </div>
    <!-- END MAIN CONTAINER -->

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="{!! asset('template/plugins/jquery/jquery.min.js') !!}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{!! asset('template/plugins/jquery-ui/jquery-ui.min.js') !!}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{!! asset('template/plugins/bootstrap/js/bootstrap.bundle.min.js') !!}"></script>
<!-- ChartJS -->
<script src="{!! asset('template/plugins/chart.js/Chart.min.js') !!}"></script>
<!-- Sparkline -->
<script src="{!! asset('template/plugins/sparklines/sparkline.js') !!}"></script>
<!-- JQVMap -->
<script src="{!! asset('template/plugins/jqvmap/jquery.vmap.min.js') !!}"></script>
<script src="{!! asset('template/plugins/jqvmap/maps/jquery.vmap.usa.js') !!}"></script>
<!-- jQuery Knob Chart -->
<script src="{!! asset('template/plugins/jquery-knob/jquery.knob.min.js') !!}"></script>
<!-- daterangepicker -->
<script src="{!! asset('template/plugins/moment/moment.min.js') !!}"></script>
<script src="{!! asset('template/plugins/daterangepicker/daterangepicker.js') !!}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{!! asset('template/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') !!}"></script>
<!-- Summernote -->
<script src="{!! asset('template/plugins/summernote/summernote-bs4.min.js') !!}"></script>
<!-- overlayScrollbars -->
<script src="{!! asset('template/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') !!}"></script>
<!-- AdminLTE App -->
<script src="{!! asset('template/dist/js/adminlte.js') !!}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{!! asset('template/dist/js/pages/dashboard.js') !!}"></script>



<script src="{!! asset('template/plugins/datatables/jquery.dataTables.min.js') !!}"></script>
<script src="{!! asset('template/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') !!}"></script>
<script src="{!! asset('template/plugins/datatables-responsive/js/dataTables.responsive.min.js') !!}"></script>
<script src="{!! asset('template/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') !!}"></script>
<script src="{!! asset('template/plugins/datatables-buttons/js/dataTables.buttons.min.js') !!}"></script>
<script src="{!! asset('template/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') !!}"></script>

<script src="{!! asset('template/plugins/jszip/jszip.min.js') !!}"></script>
<script src="{!! asset('template/plugins/pdfmake/pdfmake.min.js') !!}"></script>
<script src="{!! asset('template/plugins/pdfmake/vfs_fonts.js') !!}"></script>
<script src="{!! asset('template/plugins/datatables-buttons/js/buttons.html5.min.js') !!}"></script>
<script src="{!! asset('template/plugins/datatables-buttons/js/buttons.print.min.js') !!}"></script>
<script src="{!! asset('template/plugins/datatables-buttons/js/buttons.colVis.min.js') !!}"></script>


<script>
  $(function () {
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
      event.preventDefault();
      $(this).ekkoLightbox({
        alwaysShowClose: true
      });
    });

    $('.filter-container').filterizr({gutterPixels: 3});
    $('.btn[data-filter]').on('click', function() {
      $('.btn[data-filter]').removeClass('active');
      $(this).addClass('active');
    });
  })
</script>
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    <script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
</body>
</html>