@extends('layouts.admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> 

@section('content')
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12">
        
       <form method="post" action="{{route('growers.store') }}" name="add_name" id="add_name">
        {{ csrf_field() }}
        <div class="card">
          <div class="card-header">
            <strong>Grower Registration</strong>
            <a href="/growers/" class="btn btn-primary btn-sm pull-right"><i style="color:white;" class="fa fa-align-justify"></i> Growers List</a>
          </div>

          <div class="card-body">
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_name">Grower Name</label>
                  <input class="form-control" id="grower_name" name="grower_name" type="text" placeholder="Grower Full Name">
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_rep">Grower Representative</label>
                  <input class="form-control" id="grower_rep" name="grower_rep" type="text" placeholder="Grower Representative">
                </div>
              </div>
            </div>
            <!-- /.row-->
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_address">Grower Address</label>
                  <input class="form-control" id="grower_address" name="grower_address" type="text" placeholder="Grower Address">
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_address">Grower Type</label>
                  <select class="form-control js-example-basic-single" name="grower_type" id="grower_type">
                    @if(Auth::user()->organization == 'NF')
                    <option value="NFGrower">NF Grower</option>
                    @elseif(Auth::user()->organization == 'NTC' or Auth::user()->organization == 'NTS')
                    <option value="NTGrower">NT Grower</option>
                    @else
                    <option value="NTGrower">NT Grower</option>
                    <option value="NFGrower">NF Grower</option>
                    @endif
                  </select> 
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="national_id">National ID Number</label>
                  <input class="form-control" id="national_id" name="national_id" type="text" placeholder="National ID Number">
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_type">Grower Size</label>
                  <select class="js-example-basic-single form-control" id="grower_size" name="grower_size">
                    <option value="small_scale">Small Scale</option>
                    <option value="commercial">Commercial</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="province">Select Province</label>
                  <select class="js-example-basic-single form-control" id="province" name="province">
                    @foreach($provinces as $province)
                    <option value="{{ $province->id }}" selected>{{ $province->province }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="district">District</label>
                  <select class="js-example-basic-single form-control" id="district" name="district">
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_number">Grower Number</label>
                  <input class="form-control" id="grower_number" name="grower_number" type="text" placeholder="Enter Grower Number">
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_number">Foreign Grower Number/TIMB Number</label>
                  <input class="form-control" id="foreign_grower_number" name="foreign_grower_number" type="text" placeholder="TIMB Number">
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_agent">Grower Agent (Field Assessor/Project Manager)</label>
                  <select name="grower_agent" id="grower_agent" class="js-example-basic-single form-control">
                    @foreach($agents as $agent)
                    <option value="{{ $agent->id }}" selected> {{ $agent->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              {{--<div class="col-sm-4">
                <div class="form-group">
                  <label for="agent_type">Agent Type</label>
                  <input class="form-control" id="agent_type" name="agent_type" type="text" placeholder="Agent Type">
                </div>
              </div>--}}
            </div>

            <hr style="border-color: black;">
			<br>

			<!-- the dynamic field for adding growers is suppped to go here -->
			<div class="clearfix" id="dynamic_field">
				<div class="row">
					<div class="col-md-5">
						<div class="form-group">
              <input type="text" placeholder="Phone Number" required id="phone_number" name="phone_number[]" spellcheck="false" class="form-control" value=""/>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
              <input type="email" placeholder="Email Address" id="email" required name="email[]" spellcheck="false" class="form-control" value=""/>
						</div>
					</div>
					<div class="col-md-1">
						<button type="button" name="add" id="add" class="btn add-more btn-primary"> &nbsp;+&nbsp; </button>
					</div>
				</div>
			</div>
			<!-- end of dynamic field -->

			<hr style="border-color: black;">
			<br>
        <h6 style="color:red;">*NB - The first bank will be set as default</h6>
        <div class="clearfix" >
          <div id="dynamic_bank">     
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                    <input type="text" placeholder="Bank Name" required id="bank_name" name="bank_name[]" spellcheck="false" class="form-control" value=""/>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                    <input type="text" placeholder="Account Name" id="account_name" required name="account_name[]" spellcheck="false" class="form-control" value=""/>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                    <input type="text" placeholder="Account Number" id="account_number" required name="account_number[]" spellcheck="false" class="form-control" value=""/>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                    <input type="text" placeholder="Branch Name" id="branch_name" required name="branch_name[]" spellcheck="false" class="form-control" value=""/>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                    <input type="text" id="sort_code" placeholder="Sort Code" required name="sort_code[]" spellcheck="false" class="form-control" value=""/>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                    <input type="text" id="bank_priority"placeholder="Priority" required name="bank_priority[]" spellcheck="false" class="form-control" value=""/>
                </div>
              </div>
              <div class="col-md-1 col-form-label">
                <div class="form-check">
                  <input class="form-check-input" id="radio1" type="radio" name="default_bank" value="1" checked="checked">
                  <label class="form-check-label" for="radio1">Default</label>
                </div>
              </div>
              <div class="col-md-1">
                <button type="button" name="addBank" id="addBank" class="btn add-more btn-primary"> &nbsp;+&nbsp; </button>
              </div>
            </div>
            <hr style="border-color: grey;border-style: dashed;">
          </div>
        </div>
          </div>
          <div class="card-footer">
            <div class="form-group pull-right">
    				<input type="submit" class="btn btn-success" value="Save New Grower"/>
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
<!-- for adding grower contacts -->
<script type="text/javascript">
    $(document).ready(function(){      
      var i=1;  

      //method for adding a dynamic field for the 
      $('#add').click(function(){  
           i++;  
           $('#dynamic_field').append('<div id="row'+i+'" class="row dynamic-added"><hr><div class="col-md-5"><div class="form-group"><div class="form-line" id="field"><input type="text" placeholder="Phone Number" required name="phone_number[]" spellcheck="false" class="form-control" value=""/></div></div></div><div class="col-md-6"><div class="form-group"><div class="form-line"><input type="email" placeholder="Email Address" id="email" required name="email[]" spellcheck="false" class="form-control" value=""/></div></div></div><div class="col-md-1"><button type="button" name="remove" id="'+i+'" class="btn btn_remove btn-danger"> &nbsp;x&nbsp; </button></div></div>');
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
<script type="text/javascript">
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
</script>