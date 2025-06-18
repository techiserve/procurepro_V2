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

     // Remove vendor-related fields completely
    $filteredFields = $formFields->reject(function ($field) use ($vendorNames) {
        return in_array(strtolower($field->name), array_map('strtolower', $vendorNames));
    });
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

                
                </div>
            </div>
        @endforeach
    </div>
@endforeach


              
			<hr style="border-color: black;">
      <!-- document upload -->
      <div class="clearfix" id="dynamic_field">
     <div class="row" id="row1">

                         <div class="col-sm-2">
                    <label>Is Vendor One-Time?</label><br>
                    <label class="radio-inline">
                      <input type="radio" name="is_one_time_vendor_1" value="yes" onchange="toggleVendorTypeDynamic(1, this.value)"> Yes
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="is_one_time_vendor_1" value="no" checked onchange="toggleVendorTypeDynamic(1, this.value)"> No
                    </label>
                 
                  </div>
                  <div class="col-sm-3">
                    <div class="form-group">
                      <label>Vendor Name</label>
                        <input type="hidden" name="vendor_final[]" id="finalVendorInput_1">
                    <input type="text" class="form-control" id="oneTimeVendorInput_1" style="display:none; margin-top:5px;" placeholder="One-Time Vendor Name" oninput="updateFinalVendorValue(1, this.value)">
                    <select class="form-control" id="vendorDropdown_1" style="display:block; margin-top:5px;" onchange="updateFinalVendorValue(1, this.value)">
                      <option value="">Select Vendor</option>
                      @foreach($vendors as $vendor)
                        <option value="{{ $vendor->SupplierName }}">{{ $vendor->SupplierName }}</option>
                      @endforeach
                    </select>
                    </div>
                  </div>
                  <div class="col-sm-3">
                    <div class="form-group">
                      <label>Upload Document</label>
                      <input type="file" class="form-control" name="dfile[]" required>
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group">
                      <label>Amount</label>
                      <input type="number"   class="form-control" name="damount[]" required>
                    </div>
                  </div>

        <div class="col-sm-2">
          <button type="button" name="add" id="add" class="btn add-more btn-primary" style="margin-top: 25px;"> &nbsp;+&nbsp; </button>
        </div>
      </div>
      </div>
          <!-- One-Time Vendor Modal for Row 1 -->
       <div class="modal fade" id="oneTimeVendorModal_1" tabindex="-1" role="dialog" aria-labelledby="oneTimeVendorModalLabel_1" aria-hidden="true">
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
                        <input type="text" class="form-control" id="modalVendorName_1" placeholder="Vendor Name">
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
                      <button type="button" class="btn btn-primary" onclick="saveOneTimeVendor(1)">Done</button>
                    </div>
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
  let i = 1;
  $('#add').click(function(){
    i++;
    const rowId = 'row' + i;
    const modalId = 'oneTimeVendorModal_' + i;

    $('#dynamic_field').append(`
      <div id="${rowId}" class="row dynamic-added">
        <div class="col-sm-2">
          <label>Is Vendor One-Time?</label><br>
          <label class="radio-inline">
            <input type="radio" name="is_one_time_vendor_${i}" value="yes" onchange="toggleVendorTypeDynamic(${i}, this.value)"> Yes
          </label>
          <label class="radio-inline">
            <input type="radio" name="is_one_time_vendor_${i}" value="no" onchange="toggleVendorTypeDynamic(${i}, this.value)"> No
          </label>
         
        </div>

        <div class="col-sm-3">
          <div class="form-group">
            <label>Vendor Name</label>
           <input type="hidden" name="vendor_final[]" id="finalVendorInput_${i}">
          <input type="text" class="form-control" id="oneTimeVendorInput_${i}" style="display:none; margin-top:5px;" placeholder="One-Time Vendor Name" oninput="updateFinalVendorValue(${i}, this.value)">
          <select class="form-control" id="vendorDropdown_${i}" style="display:block; margin-top:5px;" onchange="updateFinalVendorValue(${i}, this.value)">
            <option value="">Select Vendor</option>
            @foreach($vendors as $vendor)
              <option value="{{ $vendor->SupplierName }}">{{ $vendor->SupplierName }}</option>
            @endforeach
          </select>
          </div>
        </div>

        <div class="col-sm-3">
          <div class="form-group">
            <label>Upload Document</label>
            <input type="file" class="form-control" name="dfile[]" required>
          </div>
        </div>

        <div class="col-sm-2">
                    <div class="form-group">
                      <label>Amount</label>
                      <input type="number"  class="form-control" name="damount[]" required>
                    </div>
        </div>

        <div class="col-sm-2">
          <button type="button" name="remove" id="${i}" class="btn btn_remove btn-danger" style="margin-top: 25px;">&nbsp;x&nbsp;</button>
        </div>
      </div>

      <div class="modal fade" id="${modalId}" tabindex="-1" role="dialog" aria-labelledby="modalLabel_${i}" aria-hidden="true">
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
                <input type="text" class="form-control" id="modalVendorName_${i}" placeholder="Vendor Name">
              </div>
              <div class="form-group">
                <label>Type</label>
                <select class="form-control" name="type[]">
                  <option value="">--Select--</option>
                  @foreach($vendorTypes as $type)
                    <option value="{{ $type->name }}">{{ $type->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label>Vat Allocation</label>
                <input type="text" class="form-control" name="Vatallocation[]">
              </div>
              <div class="form-group">
                <label>Supplier Code</label>
                <input type="text" class="form-control" name="supplierCode[]">
              </div>
              <div class="form-group">
                <label>Bank</label>
                <input type="text" class="form-control" name="bank[]">
              </div>
              <div class="form-group">
                <label>Account Number</label>
                <input type="text" class="form-control" name="accountNumber[]">
              </div>
              <div class="form-group">
                <label>Account Type</label>
                <input type="text" class="form-control" name="accountType[]">
              </div>
              <div class="form-group">
                <label>Upload Document</label>
                <input type="file" class="form-control" name="doc[]">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" onclick="saveOneTimeVendorDynamic(${i})">Done</button>
            </div>
          </div>
        </div>
      </div>
    `);
  });

  $(document).on('click', '.btn_remove', function(){
    const button_id = $(this).attr("id");
    $('#row' + button_id).remove();
    $('#oneTimeVendorModal_' + button_id).remove();
  });
});

function toggleVendorTypeDynamic(index, value) {
  const dropdown = document.getElementById(`vendorDropdown_${index}`);
  const oneTimeInput = document.getElementById(`oneTimeVendorInput_${index}`);
  const modal = $(`#oneTimeVendorModal_${index}`);

  if (value === 'yes') {
    dropdown.style.display = 'none';
    oneTimeInput.style.display = 'block';
    oneTimeInput.value = '';
    updateFinalVendorValue(index, '');
    modal.modal('show');
  } else if (value === 'no') {
    dropdown.style.display = 'block';
    oneTimeInput.style.display = 'none';
    oneTimeInput.value = '';
    updateFinalVendorValue(index, dropdown.value);
  }
}

function saveOneTimeVendorDynamic(index) {
  const vendorName = document.getElementById(`modalVendorName_${index}`).value;
  const oneTimeInput = document.getElementById(`oneTimeVendorInput_${index}`);
  if (!vendorName) {
    Swal.fire('Error', 'Please enter the Vendor Name', 'error');
    return;
  }
  oneTimeInput.value = vendorName;
  updateFinalVendorValue(index, vendorName);
  $(`#oneTimeVendorModal_${index}`).modal('hide');
}

function updateFinalVendorValue(index, value) {
  document.getElementById(`finalVendorInput_${index}`).value = value;
}
</script>