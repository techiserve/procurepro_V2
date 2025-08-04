@extends('stack.layouts.admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> 

@section('content')
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12">
        
       <form method="post" action="/executives/store" name="add_name" id="multiple_assign">
       @csrf
        <div class="card">
          <div class="card-header">
            <strong>Executive Registration</strong>
            <a href="/growers/" class="btn btn-primary btn-sm pull-right"><i style="color:white;" class="fa fa-align-justify"></i> Executives List</a>
          </div>

          <div class="card-body">
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_nam">Executive Name</label>
                  <input class="form-control" id="grower_nam" name="executiveName" type="text" placeholder="Executive Name">
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_rep">Username</label>
                  <input class="form-control" id="username" name="username" type="text" placeholder="Username">
                </div>
              </div>
            </div>
            <!-- /.row-->
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_address">Password</label>
                  <input class="form-control" id="grower_address" name="password" type="password" placeholder="Password">
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_address">Confirm Password</label>
                  <input class="form-control" id="grower_address" name="confirmPassword" type="password" placeholder="Confirm Password">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="national_id">Email</label>
                  <input class="form-control" id="national_id" name="email" type="email" placeholder="Email">
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="province">Address</label>
                  <textarea class="form-control" id="exampleFormControlTextarea1" name="address" rows="3"></textarea>
                </div>
              </div>

       
            </div>


            <hr style="border-color: black;">
			<br>
               <div class="row">
  <div class="col-sm-12">
    <div class="form-group">
      <label><strong>Select Companies</strong></label>
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th style="width: 50px;"><input type="checkbox" id="select-all"></th>
            <th>Company Name</th>
            <th>Email</th>
            <th>Location</th>
          </tr>
        </thead>
        <tbody>
          @foreach($companies as $company)
          <tr>
            <td>
              <input type="checkbox" name="company_ids[]" value="{{ $company->id }}" class="company-checkbox">
            </td>
            <td>{{ $company->name }}</td>
            <td>{{ $company->email }}</td>
            <td>{{ $company->contactPerson }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
          </div>
          <div class="card-footer">
            <div class="form-group pull-right">
    				<input type="submit" class="btn btn-success" value="Save"/>
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
<script>
    $(document).ready(function () {
    $('#select-all').click(function () {
      $('.company-checkbox').prop('checked', this.checked);
    });
  });
</script>
