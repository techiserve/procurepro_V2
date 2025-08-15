@extends('html.default')

@section('content')
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-12"><!-- Full width -->
        
        <form method="POST" action="/users/{{ $user->id }}/update">
          @csrf
          @method('put')
          
          <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
              <strong>Edit User</strong>
              <a href="/users/index" class="btn btn-primary btn-sm">
                <i class="fa fa-align-justify"></i> Users List
              </a>
            </div>

            <div class="card-body">
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Name</label>
                    <input class="form-control" name="name" value="{{ $user->name }}" type="text" placeholder="Name">
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Phone Number</label>
                    <input class="form-control" name="phonenumber" value="{{ $user->phoneNumber }}" type="text" placeholder="Phone Number">
                  </div>
                </div>
              </div>
     
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Password</label>
                    <input class="form-control" name="password" type="password" placeholder="********">
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Confirm Password</label>
                    <input class="form-control" name="confirmpassword" type="password" placeholder="********">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Role</label>
                    <select class="form-control" name="role">
                      @foreach($roles as $role)
                        @if($role->id == $user->userrole)
                          <option value="{{ $role->id }}">{{ $role->name }}</option>  
                        @endif
                      @endforeach
                      @foreach($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Department</label>
                    <select class="form-control" name="department">
                      @foreach($departments as $department)
                        @if($department->id == $user->department)
                          <option value="{{ $department->id }}">{{ $department->name }}</option>  
                        @endif
                      @endforeach
                      @foreach($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Position</label>
                    <input class="form-control" name="position" value="{{ $user->position }}" type="text" placeholder="Position">
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Email Address</label>
                    <input class="form-control" name="email" type="text" value="{{ $user->email }}" placeholder="Email Address">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Address</label>
                    <textarea class="form-control" name="address" rows="3">{{ $user->address }}</textarea>
                  </div>
                </div>

                <div class="col-sm-3 d-flex align-items-center">
                  @php $active = $user->isActive; @endphp
                  <div class="form-check form-switch mt-3">
                    <input class="form-check-input" type="checkbox" role="switch" name="IsActive" value="1" id="flexSwitchCheckDefault" @if($active) checked @endif>
                    <label class="form-check-label" for="flexSwitchCheckDefault">Active</label>
                  </div>
                </div>
              </div>

              <hr style="border-color: black;">
            </div>

            <div class="card-footer text-end">
              <input type="submit" class="btn btn-success" value="Update"/>
              <input type="reset" class="btn btn-danger" value="Cancel"/>
            </div>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>
@endsection
