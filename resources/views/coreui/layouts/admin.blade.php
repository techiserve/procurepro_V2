<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="ie-edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="userid" content="{{ Auth::check() ? Auth::user()->id : '' }}">

    <title>Procure Pro 360</title>
    @include('coreui.layouts.admin.meta')
    @include('coreui.layouts.admin.stylesheets')
    @yield('styles')
</head>

<body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
    
@include('coreui.admin.partials.navbar')

    <div class="app-body">

        @include('coreui.admin.partials.sidebar')
        <main class="main" >
        <!-- Breadcrumb-->
        <ol class="breadcrumb">       
          <li class="breadcrumb-item active">
        
          </li>
          <!-- Breadcrumb Menu-->        
        </ol>

        <!-- /.modal for disbursing inputs-->
          <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-danger modal-md" role="document">
              <form method="post" action="">
                {{ csrf_field() }}
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">Report Error</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                  </div>
                  <div class="modal-body">
                      <div class="form-group">
                          <label for="url">Url/Link</label>
                          <input type="text" name="url" class="form-control" placeholder="e.g. http://localhost/home" maxlength="150" required/>
                      </div>

                      <div class="form-group">
                          <label for="amount">Description</label>
                          <textarea class="form-control" id="textarea-input" name="description" rows="5" maxlength="150" placeholder="e.g. The submit button on the create grower form is not working." required></textarea>
                      </div>

                  </div>
                  <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-danger" type="submit">Submit Report</button>
                  </div>
                </div>
              </form>
              <!-- /.modal-content-->
            </div>
            <!-- /.modal-dialog-->
          </div>
          <!-- /.modal-->

            @yield('content') 

        </main>
    </div>
  @include('coreui.admin.partials.footer')
  <div id="loader"></div>
@include('coreui.layouts.admin.scripts')
@include('sweetalert::alert')
<script>
  window.Laravel = {!! json_encode([
    'csrfToken' => csrf_token(),
  ]) !!};
</script>

@yield('scripts')
</body>
</html>