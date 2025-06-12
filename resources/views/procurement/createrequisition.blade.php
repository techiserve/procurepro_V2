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
      $invoiceNames = ['invoiceamount', 'invoice amount', 'invoices','Invoice'];
      $bankNames = ['bank', 'bank list', 'banks','Bank','BANKS','BANK'];
      $expensesNames = ['expenses', 'expense','Expenses','Classification Of Expenses','coe','classification of expenses','clasification of expenses'];
@endphp

@foreach($formFields->chunk(2) as $fieldPair)
    <div class="row">
        @foreach($fieldPair as $field)
            <div class="col-md-6">
                <div class="form-group">
                  @if(in_array($field->name, array_map('strtolower', $invoiceNames)))
                
                  @else
                   <label>{{ $field->label }}</label>
                  @endif
                    @php
                        $fieldNameLower = strtolower($field->name);
                    @endphp

                    @if($field->type === 'checkbox')
                  </br>   <!-- <input type="text" class="form-control" name="{{ $field->name }}"> -->
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="{{ $field->name }}" value="Yes" {{ old($field->name) == 'Yes' ? 'checked' : '' }}>
                            <label class="form-check-label">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="{{ $field->name }}" value="No" {{ old($field->name) == 'No' ? 'checked' : '' }}>
                            <label class="form-check-label">No</label>
                        </div>

                    @else

  @if(in_array($fieldNameLower, array_map('strtolower', $vendorNames)))
<div class="form-group">
    <label>Is Vendor One-Time?</label><br>
    <label class="radio-inline">
        <input type="radio" name="is_one_time_vendor_{{ $field->name }}" value="yes" onchange="toggleVendorType('{{ $field->name }}', this.value)"> Yes
    </label>
    <label class="radio-inline">
        <input type="radio" name="is_one_time_vendor_{{ $field->name }}" value="no" onchange="toggleVendorType('{{ $field->name }}', this.value)"> No
    </label>
{{-- </div> --}}
<input type="hidden" name="{{ $field->name }}" id="finalVendorInput_{{ $field->name }}">

<!-- Vendor Dropdown (for regular vendors) -->
<label>Select Vendor</label>
<select class="js-example-basic-single form-control" id="vendorDropdown_{{ $field->name }}" onchange="updateFinalVendorValue('{{ $field->name }}', this.value)">
    <option value="">Select Vendor</option>
    @foreach($vendors as $vendor)
        <option value="{{ $vendor->SupplierName }}">{{ $vendor->SupplierName }}</option>
    @endforeach
</select>

<!-- One-time vendor input -->
<input type="text" class="form-control" id="oneTimeVendorInput_{{ $field->name }}" style="display: none;" placeholder="One-Time Vendor Name" oninput="updateFinalVendorValue('{{ $field->name }}', this.value)">
</div>

<!-- Modal for one-time vendor -->
<div class="modal fade" id="oneTimeVendorModal_{{ $field->name }}" tabindex="-1" role="dialog" aria-labelledby="oneTimeVendorModalLabel_{{ $field->name }}" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">One-Time Vendor Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <label>Vendor Name</label>
            <input type="text" class="form-control" id="modalVendorName_{{ $field->name }}" placeholder="Vendor Name">
        </div>
        <div class="form-group">
            <label>Type</label>
            <select class="form-control" name="type">
                <option value="">--Select--</option>
                @foreach($vendorTypes as $type)
                    <option value="{{ $type->name }}">{{ $type->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Vat Allocation</label>
            <input type="text" class="form-control" name="Vatallocation">
        </div>
        <div class="form-group">
            <label>Supplier Code</label>
            <input type="text" class="form-control" name="supplierCode">
        </div>
        <div class="form-group">
            <label>Bank</label>
            <input type="text" class="form-control" name="bank">
        </div>
         <div class="form-group">
            <label>Account Number</label>
            <input type="text" class="form-control" name="accountNumber">
        </div>
        <div class="form-group">
            <label>Account Type</label>
            <input type="text" class="form-control" name="accountType">
        </div>
        <div class="form-group">
            <label>Upload Document</label>
            <input type="file" class="form-control" name="doc">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="saveOneTimeVendor('{{ $field->name }}')">Done</button>
      </div>
    </div>
  </div>
</div>








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

                          @elseif(in_array($fieldNameLower, array_map('strtolower', $bankNames)))
                            <select class="js-example-basic-single form-control" name="{{ $field->name }}">
                                <option value="">Select Bank</option>
                              @foreach($banks as $bank)
                                    <option value="{{ $bank->name }}">{{ $bank->name }}</option>
                                @endforeach
                            </select>

                           @elseif(in_array($fieldNameLower, array_map('strtolower', $invoiceNames)))
                         

                        @elseif(in_array($fieldNameLower, array_map('strtolower', $expensesNames)))
                            <select class="js-example-basic-single form-control" name="{{ $field->name }}">
                                <option value="">Select Expense</option>
                                @foreach($expenses as $expense)
                                    <option value="{{ $expense->name }}">{{ $expense->name }}</option>
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


function toggleVendorType(fieldName, value) {
    const dropdown = document.getElementById(`vendorDropdown_${fieldName}`);
    const oneTimeInput = document.getElementById(`oneTimeVendorInput_${fieldName}`);
    const modal = $(`#oneTimeVendorModal_${fieldName}`);

    if (value === 'yes') {
        dropdown.style.display = 'none';
        oneTimeInput.style.display = 'block';
        oneTimeInput.value = '';
        updateFinalVendorValue(fieldName, '');
        modal.modal('show');
    } else if (value === 'no') {
        dropdown.style.display = 'block';
        oneTimeInput.style.display = 'none';
        oneTimeInput.value = '';
        updateFinalVendorValue(fieldName, dropdown.value);
    }
}

function saveOneTimeVendor(fieldName) {
    const vendorName = document.getElementById(`modalVendorName_${fieldName}`).value;
    const oneTimeInput = document.getElementById(`oneTimeVendorInput_${fieldName}`);

    if (!vendorName) {
        Swal.fire('Error', 'Please enter the Vendor Name', 'error');
        return;
    }

    oneTimeInput.value = vendorName;
    updateFinalVendorValue(fieldName, vendorName); // sync to hidden input
    $(`#oneTimeVendorModal_${fieldName}`).modal('hide');
}


function updateFinalVendorValue(fieldName, value) {
    document.getElementById(`finalVendorInput_${fieldName}`).value = value;
}

</script>