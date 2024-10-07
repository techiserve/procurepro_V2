@extends('coreui.layouts.admin')

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
                  <label for="grower-id">Assign Company</label>
                  <select class="js-example-basic-multiple form-control" multiple="multiple"id="grower_name" name="compan[]" >
                  @foreach($companies as $company)
                    <option value="{{ $company->id }}"> {{ $company->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="province">Address</label>
                  <textarea class="form-control" id="exampleFormControlTextarea1" name="address" rows="3"></textarea>
                </div>
              </div>

       
            </div>


            <hr style="border-color: black;">
			<br>

			<!-- the dynamic field for adding growers is suppped to go here -->
			<div class="clearfix" id="dynamic_field">
				<div class="row">
					<div class="col-md-5">
						<div class="form-group">
                         <!-- <input type="text" placeholder="Phone Number" required id="phone_number" name="phone_number[]" spellcheck="false" class="form-control" value=""/> -->
                         <select class="js-example-basic-single form-control" id="grower_size" name="company[]">
                          <option value="" >Select Company</option>
                           @foreach($companies as $company)
                            <option value="{{ $company->id }}"> {{ $company->name }}</option>
                            @endforeach
                        </select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
                        <!-- <input type="email" placeholder="Email Address" id="email" required name="email[]" spellcheck="false" class="form-control" value=""/> -->
                        <select class="js-example-basic-single form-control" id="grower_sizes" name="userrole[]">
                          <option value="" >Select User Role</option>                       
                            <option value="4">Finance Manager</option>                          
                            <option value="5">Normal End User</option>
                            <option value="6">Manager</option>                         
                            <option value="7">Stress Test Role</option>                         
                        </select>
						</div>
					</div>
					<div class="col-md-1">
						<button type="button" name="add" id="add" class="btn add-more btn-primary"> &nbsp;+&nbsp; </button>
					</div>
				</div>
			</div>
			<!-- end of dynamic field -->
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
<!-- for adding grower contacts -->
<script type="text/javascript">
    $(document).ready(function(){      
      var i=1;  

      //method for adding a dynamic field for the 
      $('#add').click(function(){  
           i++;  
           $('#dynamic_field').append('<div id="row'+i+'" class="row dynamic-added"><hr><div class="col-md-5"><div class="form-group"><div class="form-line" id="field"><select class="js-example-basic-single form-control" id="grower_size" name="company[]"><option value="" >Select Company</option> @foreach($companies as $company)<option value="{{ $company->id }}"> {{ $company->name }}</option>@endforeach</select></div></div></div><div class="col-md-6"><div class="form-group"><div class="form-line">  <select class="js-example-basic-single form-control" id="grower_sizes" name="userrole[]"><option value="" >Select User Role</option><option value="4">Finance Manager</option><option value="5">Normal End User</option><option value="6">Manager</option><option value="7">Stress Test Role</option></select></div></div></div><div class="col-md-1"><button type="button" name="remove" id="'+i+'" class="btn btn_remove btn-danger"> &nbsp;x&nbsp; </button></div></div>');
      });  

      //method for row removal using button
      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  

    });  
</script>
<!-- end of method used for adding grower contacts dynamic fields-->

<!-- for  adding bank details -->
<!-- <script type="text/javascript">
	$(document).ready(function(){

		var i = 1;

		//method for adding dynamic fileds for the bank details
		$('#addBank').click(function(){
			i++;
			$('#dynamic_bank').append('<div id="row'+i+'" class="row dynamic-added"><div class="col-md-4"><div class="form-group"><div class="form-line" id="field"><input type="text" placeholder="Bank Name" required name="bank_name[]" spellcheck="false" class="form-control" value=""/></div></div></div><div class="col-md-4"><div class="form-group"><div class="form-line"><input type="text" placeholder="Account Name" id="account_name" required name="account_name[]" spellcheck="false" class="form-control" value=""/></div></div></div><div class="col-md-4"><div class="form-group"><div class="form-line"><input type="text" placeholder="Account Number" id="account_number" required name="account_number[]" spellcheck="false" class="form-control" value=""/></div></div></div><div class="col-md-4"><div class="form-group"><div class="form-line"><input type="text" placeholder="Branch Name" required name="branch_name[]" spellcheck="false" class="form-control" value=""/></div></div></div><div class="col-md-3"><div class="form-group"><div class="form-line"><input type="text" placeholder="Sort Code" required name="sort_code[]" spellcheck="false" class="form-control" value=""/></div></div></div><div class="col-md-4"><div class="form-group"><div class="form-line"><input type="text" placeholder="Priority" required name="bank_priority[]" spellcheck="false" class="form-control" value=""/></div></div></div><div class="col-md-1"><button type="button" name="remove" id="'+i+'" class="btn btn_remove_bank btn-danger"> &nbsp;x&nbsp; </button></div></div>');
		});

		//method for row removal using a remove button
		$(document).on('click', '.btn_remove_bank', function(){
			var button_id = $(this).attr("id");
			$('#row' + button_id + '').remove();
		});

	});
</script> -->
