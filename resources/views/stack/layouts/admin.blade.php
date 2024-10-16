<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Stack admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, stack admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="userid" content="{{ Auth::check() ? Auth::user()->id : '' }}">

    <title>Procure Pro 360</title>
    @include('stack-admin.layouts.admin.meta')
    @include('stack-admin.layouts.admin.stylesheets')
    @yield('styles')
</head>

<body class="vertical-layout vertical-menu-modern 2-columns   fixed-navbar" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
    
@include('stack-admin.admin.partials.navbar')

    <div class="app-body">

        @include('stack-admin.admin.partials.sidebar')
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
  @include('stack-admin.admin.partials.footer')
  <div id="loader"></div>
@include('stack-admin.layouts.admin.scripts')
@include('sweetalert::alert')
<script>
  window.Laravel = {!! json_encode([
    'csrfToken' => csrf_token(),
  ]) !!};
</script>

@yield('scripts')
</body>
</html>