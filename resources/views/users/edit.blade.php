@extends('stack.layouts.admin')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

@section('content')
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12">
        
       <form method="POST" action="/users/{{ $user->id }}/update">
       @csrf
       @method('put')
        <div class="card">
          <div class="card-header">
            <strong>Add New User</strong>
            <a href="/users/index" class="btn btn-primary btn-sm pull-right"><i style="color:white;" class="fa fa-align-justify"></i> Users List</a>
           </div>

           <div class="card-body">
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_name">Name</label>
                  <input class="form-control" id="grower_name" name="name" value="{{$user->name}}" type="text" placeholder="Name">
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_rep">Phone Number</label>
                  <input class="form-control" id="grower_rep" name="phonenumber" value="{{$user->phoneNumber}}" type="text" placeholder="Phone Number">
                </div>
              </div>
            </div>
     
               <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="grower_address">Password</label>
                    <input class="form-control" id="grower_address" name="password" type="password" placeholder="********" required>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="province">Confirm Password</label>
                    <input class="form-control" id="national_id" name="confirmpassword" type="password" placeholder="********" required>
                  </div>
                </div>
              </div>


            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_address">Role</label>
                  <select class="js-example-basic-single form-control" id="grower_size" name="role">
                         @foreach($roles as $role)
                         @if($role->id == $user->userrole)
                         <option value="{{$role->id }}" >{{$role->name}}</option>  
                         @endif
                        @endforeach

                           @foreach($roles as $role)
                            <option value="{{ $role->id }}"> {{ $role->name }}</option>
                            @endforeach
                        </select>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                <label for="national_id">Department</label>
                <select class="js-example-basic-single form-control" id="grower_sizes" name="department">

                         @foreach($departments as $department)
                         @if($department->id == $user->department)
                         <option value="{{$department->id }}" >{{$department->name}}</option>  
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
                  <label for="grower_address">Position</label>
                  <input class="form-control" id="grower_address" name="position" value="{{$user->position}}" type="text" placeholder="Position">
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                <label for="province">Email Address</label>
                  <input class="form-control" id="national_id" name="email" type="text"  value="{{$user->email}}" placeholder="Email Address">
                </div>
              </div>
            </div>

            <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_number">Address</label>
                  <textarea class="form-control" id="exampleFormControlTextarea1"  name="address" rows="3">{{$user->address}}</textarea>
                </div>
              </div>

             
              @php  $active = $user->isActive; @endphp
              <div class="col-md-1 col-form-label">
                <div class="form-group">
                <div class="form-check">
                <label for="province" style="visibility: hidden;">Email Address</label>  
                <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" name="IsActive"  value="1"  id="flexSwitchCheckDefault"  @if($active) checked @endif>
              
                <label class="form-check-label" for="defaultCheck1">
               Active
               </label>
                </div>
             
               </div>
                </div>
              </div>
          
            </div>


			<hr style="border-color: black;">
			<br>
          </div>
          <div class="card-footer">
            <div class="form-group pull-right">
    				<input type="submit" class="btn btn-success" value="Update"/>
    				<input type="reset" class="btn btn-danger" value="Cancel"/>
    			</div>
          </div>
       </div>
      </form>
     </div>
    </div>
   </div>
</div>
@endsection
