@extends('template.default')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Parameters</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Users</a></li>
              <li class="breadcrumb-item active">Parameters</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

<section class="content">
      <div class="container-fluid">
        <!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">.</h3>
            <div class="card-tools">
             
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
          <div class="row">
          <div class="card w-50">
            <div class="card-body">
            <h5 class="card-title">User Roles</h5>
            <p class="card-text">You can create and view all user roles in the platform.</p>
            <div class="btn-group">
                    <button type="button" class="btn btn-info">Action</button>
                    <button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown">
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu" role="menu">
                      <button class="dropdown-item"  data-toggle="modal" data-target="#modal-lg" >Create Role</button>
                      <a class="dropdown-item" href="#">View Roles</a>
                    </div>
                  </div>
            </div>
         </div>

         <div class="card w-50">
         <div class="card-body">
            <h5 class="card-title">Power BI Roles</h5>
            <p class="card-text">You can create and view all power bi roles in the platform</p>
            <div class="btn-group">
                    <button type="button" class="btn btn-info">Action</button>
                    <button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown">
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu" role="menu">
                    <button class="dropdown-item"  data-toggle="modal" data-target="#index-modal-lg" >Create Role</button>
                      <a class="dropdown-item" href="#">View Roles</a>
                    </div>
                  </div>
            </div>
         </div>
         </div>
          <!-- /.card-body -->
    
          
  <!-- User Role Modal -->
  <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Create User Role</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                <label for="exampleInputEmail1">Role Name</label>
                    <input type="text" class="form-control" name="name" id="exampleInputEmail1" placeholder="enter role name">
                </div>
                <!-- /.form-group -->
              
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              <div class="col-md-6">
                <div class="form-group">
                <label for="exampleInputEmail1">Description</label>
                    <input type="text" class="form-control" name="username" id="exampleInputEmail1" placeholder="enter description">
                </div>
                <!-- /.form-group -->
              
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
  <!-- End of User Role Modal -->





           
  <!-- Bi Role Modal -->
  <div class="modal fade" id="index-modal-lg">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Create power bi Role</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                <label for="exampleInputEmail1">Role Name</label>
                    <input type="text" class="form-control" name="name" id="exampleInputEmail1" placeholder="enter role name">
                </div>
                <!-- /.form-group -->
           
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              <div class="col-md-6">
              <div class="form-group">
                <label for="exampleInputEmail1">Username</label>
                    <input type="email" class="form-control" name="email" id="exampleInputEmail1" placeholder="enter username">
                </div>
                <!-- /.form-group -->
              
                <!-- /.form-group -->
              </div>
              <!-- /.col -->

              <div class="col-md-6">
                <div class="form-group">
                <label for="exampleInputEmail1">Password</label>
                    <input type="text" class="form-control" name="username" id="exampleInputEmail1" placeholder="enter password">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
           
                <!-- /.form-group -->
              </div>
            </div>
            <!-- /.row -->
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
  <!-- End of User Role Modal -->

        </div>

        </div>
              <!-- /.col -->
     </div>
            <!-- /.row -->
  </div>

  



@endsection
