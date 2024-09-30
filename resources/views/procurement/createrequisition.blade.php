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
        
       <form method="POST" action="/requisition/store"  enctype="multipart/form-data">
       @csrf
        <div class="card">
          <div class="card-header">
            <strong>Add Purchase Requisition</strong>
            <a href="/procurement/indexrequisition" class="btn btn-primary btn-sm pull-right"><i style="color:white;" class="fa fa-align-justify"></i> Requisition List</a>
           </div>

           <div class="card-body">
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_name">Vendor</label>
                  <select class="js-example-basic-single form-control" id="grower_sizesss" name="vendor">
                           <option value="" >Select Vendor</option>
                           @foreach($vendors as $vendor)
                           <option value="{{ $vendor->SupplierName }}"> {{ $vendor->SupplierName }}</option>
                           @endforeach
                  </select>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_rep">Service Types</label>
                  <select class="js-example-basic-single form-control" id="servicetype" name="service">
                          <option value="" >Select Services</option>
                           @foreach($servicetype as $servicetype)
                            <option value="{{ $servicetype->ServiceTypeDescription }}"> {{ $servicetype->ServiceTypeDescription }}</option>
                            @endforeach
                        </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_address">Property</label>
                  <select class="js-example-basic-single form-control" id="property" name="property">
                            <option value="" >Select Property</option>                       
                            @foreach($properties as $propertie)
                            <option value="{{ $propertie->PropertyName }}"> {{ $propertie->PropertyName }}</option>
                            @endforeach
                  </select>                                                     
                  </select>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_address">Transaction</label>
                  <select class="js-example-basic-single form-control" id="transaction" name="transaction">
                          <option value="" >Select Transaction</option>
                           @foreach($transcations as $transcation)
                            <option value="{{ $transcation->TransactionDescription }}"> {{ $transcation->TransactionDescription }}</option>
                            @endforeach
                        </select>
                </div>
              </div>
            </div>
     

            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_address">Payment Method</label>
                  <select class="js-example-basic-single form-control" id="grower_sizes" name="paymentmethod">
                            <option value="" >Select Payment Method</option>                       
                            <option value="EFT">EFT</option>                          
                            <option value="Credit Card">Credit Card</option>                                                         
                  </select>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_address">Department</label>
                  <select class="js-example-basic-single form-control" id="grower_size" name="department">
                          <option value="" >Select Department</option>
                           @foreach($departments as $department)
                            <option value="{{ $department->id }}"> {{ $department->name }}</option>
                            @endforeach
                        </select>
                </div>
              </div>
            </div>
     
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_address">Description of Expense</label>
                  <input class="form-control" id="grower_address" name="expenses" type="text" placeholder="Description of Expense">
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_address">Project Code</label>
                  <input class="form-control" id="grower_address" name="projectcode" type="text" placeholder="Project Code">
                </div>
              </div>
            </div>

            <div class="row">

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_type">Amount (Rands)</label>
                  <input class="form-control" id="national_id" name="amount" type="text" placeholder="Amount" required>
                </div>
              </div> 

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_address">Tax</label>
                  <select class="js-example-basic-single form-control" id="tax" name="tax">
                          <option value="" >Select Tax Type</option>
                           @foreach($tax as $tax)
                            <option value="{{ $tax->TaxTypeDescription }}"> {{ $tax->TaxTypeDescription }}</option>
                            @endforeach
                        </select>
                </div>
              </div>
          
            </div>


			<hr style="border-color: black;">
      <!-- document upload -->
      <div class="clearfix" id="dynamic_field">
      <div class="row">
				
      <div class="col-sm-6">
                <div class="form-group">
                  <input type="file" class="form-control" id="inputGroupFile04" name="file[]" aria-describedby="inputGroupFileAddon04" aria-label="Upload"  multiple required>
                </div>
              </div>  

        <div class="col-md-1">
          <button type="button" name="add" id="add" class="btn add-more btn-primary"> &nbsp;+&nbsp; </button>
        </div>
      </div>
      </div>
        <!-- document upload -->
			<br>
          </div>
          <div class="card-footer">
            <div class="form-group pull-right">
    				<input type="submit" class="btn btn-success" value="Save New Requisition"/>
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
<script type="text/javascript">
    $(document).ready(function(){      
      var i=1;  

      //method for adding a dynamic field for the 
      $('#add').click(function(){  
           i++;  
$('#dynamic_field').append('<div id="row'+i+'" <div class="row dynamic-added"><div class="col-sm-6"><div class="form-group"><input type="file" class="form-control" id="inputGroupFile04" name="file[]" aria-describedby="inputGroupFileAddon04" aria-label="Upload" required></div></div>  <div class="col-md-1"><button type="button" name="remove" id="'+i+'" class="btn btn_remove btn-danger"> &nbsp;x&nbsp; </button></div></div>');
});  

      //method for row removal using button
      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  

    });  
</script>