@extends('coreui.layouts.admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> 
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

@section('content')
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12">
        
       <form method="POST" action="/department/store">
       @csrf
        <div class="card">
          <div class="card-header">
            <strong>Add New Department</strong>
           
           </div>

           <div class="card-body">
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_name">Department Name</label>
                  <input class="form-control" id="grower_name" name="departmentname" type="text" value = "{{$department->name}}" placeholder="Enter Department Name...">
                </div>
              </div>
       

              <div class="col-md-1 col-form-label">
                <div class="form-group">
                <div class="form-check">
              
             
               </div>
                </div>
              </div>
            </div>
      

			<hr style="border-color: black;">
			<br>

            		<!-- the dynamic field for adding growers is suppped to go here -->
			<div class="clearfix" id="dynamic_field">
				<div class="row">
				
					<div class="col-md-6">
						<div class="form-group">
                        <!-- <input type="email" placeholder="Email Address" id="email" required name="email[]" spellcheck="false" class="form-control" value=""/> -->
                        <select class="js-example-basic-single form-control" id="grower_sizes" name="approval[]">
                            <option value="" >Select Approval Level</option>                       
                            <option value="1">First Line</option>                          
                            <option value="2">Second Line</option>
                            <option value="3">Third Line</option>                         
                            <option value="4">Fourth Line</option>       
                            <option value="5">Fiveth Line</option>
                            <option value="6">Sixth Line</option>                                          
                        </select>
						</div>
					</div>

                    <div class="col-md-5">
						<div class="form-group">
                         <!-- <input type="text" placeholder="Phone Number" required id="phone_number" name="phone_number[]" spellcheck="false" class="form-control" value=""/> -->
                         <select class="js-example-basic-single form-control" id="grower_size" name="role[]">
                          <option value="" >Select Role</option>
                           @foreach($roles as $role)
                            <option value="{{ $role->id }}"> {{ $role->name }}</option>
                            @endforeach
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
<script type="text/javascript">
    $(document).ready(function(){      
      var i=1;  

      //method for adding a dynamic field for the 
      $('#add').click(function(){  
           i++;  
$('#dynamic_field').append('<div id="row'+i+'" class="row dynamic-added"><hr><div class="col-md-6"><div class="form-group"><select class="js-example-basic-single form-control" id="grower_sizes" name="approval[]"><option value="" >Select Approval Level</option><option value="1">First Line</option><option value="2">Second Line</option><option value="3">Third Line</option><option value="4">Fourth Line</option><option value="5">Fiveth Line</option><option value="6">Sixth Line</option></select></div></div><div class="col-md-5"><div class="form-group"><select class="js-example-basic-single form-control" id="grower_size" name="role[]"><option value="" >Select Role</option>@foreach($roles as $role)<option value="{{ $role->id }}"> {{ $role->name }}</option>@endforeach</select></div></div><div class="col-md-1"><button type="button" name="remove" id="'+i+'" class="btn btn_remove btn-danger"> &nbsp;x&nbsp; </button></div></div>');
});  

      //method for row removal using button
      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  

    });  
</script>