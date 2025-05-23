@extends('stack.layouts.admin')
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
            <a href="/procurement/indexrequisition" class="btn btn-primary btn-sm pull-right" style="padding: 10px 20px; font-size: 16px; min-width: 100px;"><i style="color:white;" class="fa fa-align-justify"></i> Requisition List</a>
           </div>

           <div class="card-body">
          
 <hr style="border-color: black;">
@php
      $vendorNames = ['vendor', 'vendor list', 'vendors', 'Vendor', 'Vendor List'];
      $propertyNames = ['property', 'properties','Property List', 'property list'];
      $serviceNames = ['service', 'service list', 'services', 'Service List'];
      $taxtypeNames = ['Tax', 'Tax Type', 'taxtype', 'tax list', 'Tax List'];
      $paymentmethodNames = ['payment method', 'Payment Method', 'payment', 'paymentmethod'];
      $transactionNames = ['transaction', 'transaction list', 'transactions','transaction description'];
       $departmentNames = ['department', 'department list', 'departments','department description'];
@endphp

@foreach($formFields->chunk(2) as $fieldPair)
    <div class="row">
        @foreach($fieldPair as $field)
            <div class="col-md-6">
                <div class="form-group">
                    <label>{{ $field->label }}</label>

                    @php
                        $fieldNameLower = strtolower($field->name);
                    @endphp

                    @if($field->type === 'text')
                        <textarea class="form-control" name="{{ $field->name }}"></textarea>

                    @else

                        @if(in_array($fieldNameLower, array_map('strtolower', $vendorNames)))
                            <select class="js-example-basic-single form-control" name="{{ $field->name }}">
                                <option value="">Select Vendor</option>
                                @foreach($vendors as $vendor)
                                    <option value="{{ $vendor->SupplierName }}">{{ $vendor->SupplierName }}</option>
                                @endforeach
                            </select>

                        @elseif(in_array($fieldNameLower, array_map('strtolower', $departmentNames)))
                            <select class="js-example-basic-single form-control" name="{{ $field->name }}" required>
                                <option value="">Select Department</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>

                        @elseif(in_array($fieldNameLower, array_map('strtolower', $propertyNames)))
                            <select class="js-example-basic-single form-control" name="{{ $field->name }}">
                                <option value="">Select Property</option>
                                @foreach($properties as $property)
                                    <option value="{{ $property->PropertyName }}">{{ $property->PropertyName }}</option>
                                @endforeach
                            </select>

                        @elseif(in_array($fieldNameLower, array_map('strtolower', $transactionNames)))
                            <select class="js-example-basic-single form-control" name="{{ $field->name }}">
                                <option value="">Select Transaction</option>
                                @foreach($transactions as $transaction)
                                    <option value="{{ $transaction->TransactionDescription }}">{{ $transaction->TransactionDescription }}</option>
                                @endforeach
                            </select>

                        @elseif(in_array($fieldNameLower, array_map('strtolower', $serviceNames)))
                            <select class="js-example-basic-single form-control" name="{{ $field->name }}">
                                <option value="">Select Service</option>
                                @foreach($servicetypes as $servicetype)
                                    <option value="{{ $servicetype->ServiceTypeDescription }}">{{ $servicetype->ServiceTypeDescription }}</option>
                                @endforeach
                            </select>

                        @elseif(in_array($fieldNameLower, array_map('strtolower', $paymentmethodNames)))
                            <select class="js-example-basic-single form-control" name="{{ $field->name }}">
                                <option value="">Select Payment Method</option>
                                <option value="EFT">EFT</option>
                                <option value="Credit Card">Credit Card</option>
                            </select>

                        @elseif(in_array($fieldNameLower, array_map('strtolower', $taxtypeNames)))
                            <select class="js-example-basic-single form-control" name="{{ $field->name }}">
                                <option value="">Select Tax Type</option>
                                @foreach($taxes as $tax)
                                    <option value="{{ $tax->TaxTypeDescription }}">{{ $tax->TaxTypeDescription }}</option>
                                @endforeach
                            </select>

                        @else
                            <input type="{{ $field->type === 'integer' ? 'number' : 'text' }}" class="form-control" name="{{ $field->name }}">
                        @endif

                      
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endforeach


              
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
    				<input type="submit" class="btn btn-success" value="Save"  style="padding: 10px 20px; font-size: 16px; min-width: 100px;"/>
    				<input type="reset" class="btn btn-danger" value="Cancel"  style="padding: 10px 20px; font-size: 16px; min-width: 100px;"/>
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