@extends('stack.layouts.admin')

@section('content')
<div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title mb-0">Create User</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Users</a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">Create new User</a>
                                </li>
                            
                            </ol>
                        </div>
                    </div>
                </div>


                <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
                    <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
                        <div class="btn-group" role="group">
                       
                        </div><a class="btn btn-outline-primary" href="timeline-center.html"><i class="feather icon-pie-chart"></i> User List</a>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- horizontal grid start -->
                <section class="horizontal-grid" id="horizontal-grid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                            
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                    <form method="POST" action="/users/store">
  @csrf
  <div class="card">
  

    <div class="card-body">
      <div class="row">
        <div class="col-sm-6">
          <div class="form-group">
            <label for="grower_name">Name</label>
            <input class="form-control" id="grower_name" name="name" type="text" placeholder="Name">
          </div>
        </div>

        <div class="col-sm-6">
          <div class="form-group">
            <label for="grower_rep">Phone Number</label>
            <input class="form-control" id="grower_rep" name="phonenumber" type="text" placeholder="Phone Number">
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-6">
          <div class="form-group">
            <label for="grower_address">Role</label>
            <select class="js-example-basic-single form-control" id="grower_size" name="role">
              <option value="">Select Role</option>
              @foreach($roles as $role)
              <option value="{{ $role->id }}">{{ $role->name }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="col-sm-6">
          <div class="form-group">
            <label for="national_id">Department</label>
            <select class="js-example-basic-single form-control" id="grower_sizes" name="department">
              <option value="">Select Department</option>
              <option value="4">Finance</option>
              <option value="5">IT</option>
              <option value="6">Procurement</option>
              <option value="7">HR</option>
            </select>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-6">
          <div class="form-group">
            <label for="grower_address">Position</label>
            <input class="form-control" id="grower_address" name="position" type="text" placeholder="Position">
          </div>
        </div>

        <div class="col-sm-6">
          <div class="form-group">
            <label for="province">Email Address</label>
            <input class="form-control" id="national_id" name="email" type="text" placeholder="Email Address">
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-6">
          <div class="form-group">
            <label for="grower_address">Password</label>
            <input class="form-control" id="grower_address" name="password" type="password" placeholder="********">
          </div>
        </div>

        <div class="col-sm-6">
          <div class="form-group">
            <label for="province">Confirm Password</label>
            <input class="form-control" id="national_id" name="confirmpassword" type="password" placeholder="********">
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-6">
          <div class="form-group">
            <label for="grower_number">Address</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" name="address" rows="3"></textarea>
          </div>
        </div>

        <div class="col-md-1 col-form-label">
          <div class="form-group">
            <label for="province" style="visibility: hidden;">Email Address</label>
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" role="switch" name="IsActive" value="1" id="flexSwitchCheckDefault">
              <label class="form-check-label" for="defaultCheck1">Active</label>
            </div>
          </div>
        </div>
      </div>

      <hr style="border-color: black;">
      <br>
    </div>

    <div class="card-footer">
      <div class="form-group pull-right">
        <input type="submit" class="btn btn-success" value="Save">
        <input type="reset" class="btn btn-danger" value="Cancel">
      </div>
    </div>
  </div>
</form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- horizontal grid end -->

</div>
</div>

@endsection


