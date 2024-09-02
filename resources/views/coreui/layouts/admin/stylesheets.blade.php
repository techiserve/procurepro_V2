<!-- Icons-->
<link href="{{ asset('coreui/node_modules/@coreui/icons/css/coreui-icons.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('coreui/node_modules/flag-icon-css/css/flag-icon.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('coreui/node_modules/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('coreui/node_modules/simple-line-icons/css/simple-line-icons.css') }}" rel="stylesheet"/>
<!-- Main styles for this application-->
<link href="{{ asset('coreui/css/style.css') }}" rel="stylesheet"/>
<link href="{{ asset('coreui/vendors/pace-progress/css/pace.min.css') }}" rel="stylesheet"/>
<link rel="stylesheet" href="{{ asset('coreui/css/jquery.dataTables.min.css') }}"/>
<link rel="stylesheet" href="{{ asset('coreui/css/fixedHeader.dataTables.min.css') }}"/>
<!-- Latest compiled and minified CSS -->
<!-- <link rel="stylesheet" href="{{ asset('coreui/css/sweetalert2.min.css') }}"> -->
<link href="{{ asset('coreui/css/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('coreui/css/select2-bootstrap.css') }}" rel="stylesheet" />

<!-- for bootstrap datables -->

<link rel="stylesheet" href="{{ asset('coreui/css/data-table/bootstrap-table.css') }}"/>

    <!-- Global site tag (gtag.js) - Google Analytics-->
  <style type="text/css">
    table.dataTable tr th.select-checkbox.selected::after {
    content: "✔";
    margin-top: -11px;
    margin-left: -4px;
    text-align: center;
    text-shadow: rgb(176, 190, 217) 1px 1px, rgb(176, 190, 217) -1px -1px, rgb(176, 190, 217) 1px -1px, rgb(176, 190, 217) -1px 1px;
  }
  </style>

  <!-- <style>
      .progress { 
        position:relative; 
        width:100%; 
        border: 1px solid #7F98B2; 
        padding: 1px; 
        border-radius: 3px; 
      }
      .bar { 
        background-color: #B4F5B4; 
        width:0%; 
        height:25px; 
        border-radius: 3px;
      }
      .percent { 
        position:absolute; 
        display:inline-block; 
        top:3px; left:48%; 
        color: #7F98B2;
      }
  </style>   -->

  <style type="text/css">

      .overSelect {
        position: absolute;
      }

      #checkboxes {
        display: none;
      }

      #checkboxes label {
        display: block;
      }
  </style>

    
<style>
  #table_filter input {
    border-radius: 5px;
  }
</style>

  {{-- bootstrap loader--}}
  <style type="text/css">
  #loader {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    width: 100%;
    background: rgba(0,0,0,0.75) url({{ asset('coreui/img/loading.gif') }}) no-repeat center center;]
    z-index: 10000;
  }
  </style>




<script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-118965717-3"></script>
<script>
  window.dataLayer = window.dataLayer || [];

  function gtag() {
    dataLayer.push(arguments);
  }
  gtag('js', new Date());
  // Shared ID
  gtag('config', 'UA-118965717-3');
  // Bootstrap ID
  gtag('config', 'UA-118965717-5');
</script>

