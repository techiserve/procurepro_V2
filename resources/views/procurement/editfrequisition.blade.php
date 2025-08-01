@extends('stack.layouts.admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> 
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
@section('content')
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12">
    <form method="POST" action="/procurement/{{$frequisition->id}}/updaterequisition"  enctype="multipart/form-data">
       @csrf
       @method('put')
          <div class="card">
          <div class="card-header">
            <strong>View Requisition</strong>
            <a href="/procurement/indexrequisition" class="btn btn-primary btn-sm pull-right"><i style="color:white;" class="fa fa-align-justify"></i> Requistions List</a>
           </div>
@php
      $vendorNames = ['vendor', 'vendor list', 'vendors', 'Vendor', 'Vendor List'];
      $propertyNames = ['property', 'properties','Property List', 'property list'];
      $serviceNames = ['service', 'service list', 'services', 'Service List'];
      $taxtypeNames = ['Tax', 'Tax Type', 'taxtype', 'tax list', 'Tax List'];
      $paymentmethodNames = ['payment method', 'Payment Method', 'payment', 'paymentmethod'];
      $transactionNames = ['transaction', 'transaction list', 'transactions','transaction description'];
       $departmentNames = ['department', 'department list', 'departments','department description'];
        $amount = ['amount', 'Amount'];
@endphp
           <div class="card-body">
        <div class="row">
            @foreach ($formFields as $field)
                @php
                    $fieldName = $field->name;
                    $value = $frequisition->$fieldName ?? '';
                @endphp
                 
                @if(in_array($fieldName, array_map('strtolower', $paymentmethodNames)))
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ $field->label }}</label>
              <select class="js-example-basic-single form-control" name="{{ $fieldName }}">
                <option value="">Select Payment Method</option>
                <option value="EFT" {{ $value === 'EFT' ? 'selected' : '' }}>EFT</option>
                <option value="Credit Card" {{ $value === 'Credit Card' ? 'selected' : '' }}>Credit Card</option>
            </select>
                </div>
                @elseif(in_array($fieldName, array_map('strtolower', $amount)))
                   <div class="col-md-6 mb-3">
                    <label class="form-label">{{ $field->label }}</label>
                    <input type="text" class="form-control" name="{{ $fieldName }}" value="{{ $value }}" >
                </div>
                    @elseif(in_array($fieldName, array_map('strtolower', $departmentNames)))
                   <div class="col-md-6 mb-3">
                    <label class="form-label">{{ $field->label }}</label>
                    <input type="text" class="form-control" name="{{ $fieldName }}" value="{{ $departments->name ?? 'Unknown' }}"  readonly>
                </div>
                @else
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ $field->label }}</label>
                    <input type="text" class="form-control"  name="{{ $fieldName }}" value="{{ $value }}" readonly>
                </div>
                @endif
            @endforeach
        </div>

         <div class="row">
            
            <div class="col-sm-6">
          <div class="form-group">
            <label for="grower_type">Reason</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" name="reason" rows="3" readonly>{{$frequisition->reason}}</textarea>
          </div>
        </div>
        </div>
      </div>
      
			<hr style="border-color: black;">
			<br>
         
         
            <div class="card-footer">
            <div class="form-group pull-right">

    			</div> 
          </div>
      
          
       </div>
    </div>
      
</div>
</div>

    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <strong>Documents</strong>
            <small>List</small>
          </div>

          <div class="card-body">
        <table class="table table-responsive-sm table-bordered table-striped table-sm">
          <thead>
            <tr>
           
          
        
              <th class="text-center">Vendor Name</th>
              <th class="text-center">Amount</th>
              <th class="text-center">Document</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($frequisitionvendors as $faira)
              <tr>
    
                <td class="text-center">{{ $faira->vendor_final }}</td>
                <td class="text-center">R {{ number_format($faira->amount, 2) }}</td>
                <td class="text-center">
                 @if (!empty($faira->file_path))
                <a href="{{ asset('/storage/uploads/' . $faira->file_path) }}" target="_blank" class="btn btn-info btn-sm" style="color: white;">
                <span class="fa fa-eye"></span> View Document
                </a>
               @else
                    <p>No document available.</p>
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
          </div>

        </div>
      </div>
    </div>



    	<hr style="border-color: black;">
      <!-- document upload -->
 
   
    <div class="card">
          <div class="card-header">
                  <div class="card-body">
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
            <div class="card-footer">
            <div class="form-group pull-right">
    				
             <input type="submit" class="btn btn-success" value="Update"/>

    			</div> 
          </div>
           </form>
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

</div>


</div>


@endsection

<script>
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