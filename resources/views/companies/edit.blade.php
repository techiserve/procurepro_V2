@extends('stack.layouts.admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> 

@section('content')
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12">
        
       <form method="POST" action="/company/{{ $company->id }}/update" id="passwordForm" novalidate>
       @csrf
       @method('put')
        <div class="card">
          <div class="card-header">
            <strong>Edit Company</strong>
            <a href="/companies/index" class="btn btn-primary btn-md pull-right"><i style="color:white;" class="fa fa-align-justify"></i> Companies List</a>
          </div>

          <div class="card-body">
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_name">Company Name</label>
                  <input class="form-control" id="grower_name" name="companyname" value="{{ $company->name }}" type="text" placeholder="Company Name">
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_rep">Company Sub Domain</label>
                  <input class="form-control" id="grower_rep" name="companydomain" value="{{ $company->domain }}" type="text" placeholder="Company Sub Domain">
                </div>
              </div>
            </div>
     
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_address">Username</label>
                  <input class="form-control" id="grower_address" name="username" value="{{ $company->username }}" type="text" placeholder="Username">
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_address">Contact Person</label>
                  <input class="form-control" id="grower_address" name="contactPerson" value="{{ $company->contactPerson }}" type="text" placeholder="Contact Person">
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="national_id">Password</label>
                  <input class="form-control" id="new_password" name="new_password" type="password" placeholder="Password">
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_type">Confirm Password</label>
                  <input class="form-control" id="confirm_password" name="confirm_password" type="password" placeholder="Confirm Password">
                  <div class="invalid-feedback">Passwords do not match.</div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_number">Company Address</label>
                  <textarea class="form-control" id="exampleFormControlTextarea1" name="address" rows="3">{{ $company->address }}</textarea>
                </div>
              </div>

              <div class="col-sm-4">
                <div class="form-group">       
                  <label for="province">Email Address</label>
                  <input class="form-control" id="national_id" name="email" value="{{ $company->email }}" type="text" placeholder="Email Address">
                </div>
              </div>
            
              @php  $active = $company->IsActive; @endphp  
              <div class="col-md-1 col-form-label">
                <div class="form-group">
                  <div class="form-check">
                    <label for="province" style="visibility: hidden;">Email Address</label>  
                    <input class="form-check-input" type="checkbox" name="IsActive" value="1" id="defaultCheck1" @if($active) checked @endif>
                    <label class="form-check-label" for="defaultCheck1">
                      Active
                    </label>
                  </div>
                </div>
              </div>
            </div>

            <!-- New Vendor Source Dropdown -->
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="vendor_source">Vendor Source</label>
                  <select class="form-control" id="vendor_source" name="vendor_source">
                    <option value="">-- Select Vendor Source --</option>
                    <option value="Vendor Management" @if($company->vendor_source == 'Vendor Management') selected @endif>Vendor Management</option>
                    <option value="Sage" @if($company->vendor_source == 'Sage') selected @endif>Sage</option>
                    <option value="SAP" @if($company->vendor_source == 'SAP') selected @endif>SAP</option>
                  </select>
                </div>
              </div>
            </div>

            <hr style="border-color: black;">
            <br>
          </div>

          <div class="card-footer">
            <div class="form-group pull-right">
              <input type="submit" class="btn btn-success" value="Save" style="padding: 10px 20px; font-size: 16px; min-width: 100px;"/>
              <input type="reset" class="btn btn-danger" value="Cancel" style="padding: 10px 20px; font-size: 16px; min-width: 100px;"/>
            </div>
          </div>
       </div>
      </form>
     </div>
    </div>
   </div>
</div>
@endsection

<script>
document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("passwordForm").addEventListener("submit", function (event) {       
        const newPassword = document.getElementById("new_password").value;
        const confirmPassword = document.getElementById("confirm_password").value;

        if (newPassword !== confirmPassword) {
            event.preventDefault(); // Prevent form submission
            document.getElementById("confirm_password").classList.add("is-invalid");
        } else {
            document.getElementById("confirm_password").classList.remove("is-invalid");
        }
    });
});
</script>
