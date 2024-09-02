@extends('coreui.layouts.admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> 

@section('content')
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12">
        
       <form method="POST" action="/companies/store">
       @csrf
        <div class="card">
          <div class="card-header">
            <strong>Add New Company</strong>
            <a href="/companies/index" class="btn btn-primary btn-sm pull-right"><i style="color:white;" class="fa fa-align-justify"></i> Companies List</a>
           </div>

           <div class="card-body">
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_name">Company Name</label>
                  <input class="form-control" id="grower_name" name="companyname" type="text" placeholder="Company Name">
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_rep">Company Sub Domain</label>
                  <input class="form-control" id="grower_rep" name="companydomain" type="text" placeholder="Company Sub Domain">
                </div>
              </div>
            </div>
     
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_address">Username</label>
                  <input class="form-control" id="grower_address" name="username" type="text" placeholder="Username">
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_address">Contact Person</label>
                  <input class="form-control" id="grower_address" name="contactPerson" type="text" placeholder="Contact Person">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="national_id">Password</label>
                  <input class="form-control" id="national_id" name="password" type="password" placeholder="Password">
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_type">Confirm Password</label>
                  <input class="form-control" id="national_id" name="confirmPassword" type="password" placeholder="Confirm Password">
                </div>
              </div>
            </div>

            <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_number">Company Address</label>
                  <textarea class="form-control" id="exampleFormControlTextarea1" name="address" rows="3"></textarea>
                </div>
              </div>

              <div class="col-sm-4">
                <div class="form-group">       
                  <label for="province">Email Address</label>
                  <input class="form-control" id="national_id" name="email" type="text" placeholder="Email Address">
                </div>
              </div>
            
              <div class="col-md-1 col-form-label">
                <div class="form-group">
                <div class="form-check">
                <label for="province" style="visibility: hidden;">Email Address</label>  
                <input class="form-check-input" type="checkbox" name="IsActive" value="1" id="defaultCheck1">
               <label class="form-check-label" for="defaultCheck1">
               Active
               </label>
               </div>
                </div>
              </div>
          
            </div>


			<hr style="border-color: black;">
			<br>
          </div>
          <div class="card-footer">
            <div class="form-group pull-right">
    				<input type="submit" class="btn btn-success" value="Save New Company"/>
    				<input type="reset" class="btn btn-danger" value="Cancel Registration"/>
    			</div>
          </div>
       </div>
      </form>
     </div>
    </div>
   </div>
</div>
@endsection
