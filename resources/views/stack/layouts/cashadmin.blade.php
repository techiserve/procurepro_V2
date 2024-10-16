<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Rift Valley Corporation | Smart Farmer</title>
    @include('layouts.admin.meta')
    @include('layouts.admin.stylesheets')
    @yield('styles')
</head>
<body class="app header-fixed sidebar-fixed aside-menu-fixed">
    @include('admin.partials.navbar')

    <div class="app-body">
        <main class="main">
        <!-- Breadcrumb-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item active">
            <a href="/home">Home</a>
          </li>
          <li class="breadcrumb-item active">
            <a href="/home">Dashboard</a>
          </li>
          <!-- Breadcrumb Menu-->
          <li class="breadcrumb-menu d-md-down-none">
            <div class="btn-group" role="group" aria-label="Button group">
              <a style="color: red;" class="btn" data-toggle="modal" data-target="#errorModal" aria-haspopup="true" aria-expanded="false"><i class="icon-speech"></i> Report Error</a>
              <a class="btn" href="./">
                <i class="icon-graph"></i>  Dashboard | <b>{{ Auth::user()->name }}</b></a>
            </div>
          </li>
        </ol>

        <!-- /.modal for disbursing inputs-->
        <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-danger modal-md" role="document">
              <form method="post" action="{{ route('error-log.store') }} ">
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
                          <input type="text" name="url" class="form-control" placeholder="e.g. http://localhost/home" required/>
                      </div>

                      <div class="form-group">
                          <label for="amount">Description</label>
                          <textarea class="form-control" id="textarea-input" name="description" rows="5" placeholder="e.g. The submit button on the create grower form is not working."></textarea>
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
    @include('admin.partials.footer')

@include('layouts.admin.scripts')
@yield('scripts')
</body>
</html>