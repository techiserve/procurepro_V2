@extends('html.default')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> 
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

<style>
/* === Original CSS Preserved === */
.select2-container {
  width: 720px !important;
}

.select2-container .select2-selection--single {
  height: 45px !important;
  padding: 6px 12px !important;
  border: 1px solid #ccc !important;
  border-radius: 8px !important;
}

.select2-selection__rendered {
  line-height: 43px !important;
}

.select2-selection__arrow {
  height: 43px !important;
}
#vendorDropdown_1.select2-hidden-accessible + .select2-container {
  width: 100% !important; /* adjust this % as needed */
  max-width: 650px !important; /* optional, to cap width */
}
[id^="vendorDropdown_"]:not(#vendorDropdown_1).select2-hidden-accessible + .select2-container {
  width: 85% !important;
  max-width: 500px !important;
}

/* Align vendor rows neatly even with flex adjustments */
#dynamic_field .row {
  margin-bottom: 15px;
}

#dynamic_field label {
  font-weight: 500;
  white-space: nowrap;
}

#dynamic_field input[type="file"] {
  padding: 6px;
}
</style>

@section('content')
<div class="body-content__header">
  <ul>
    <li><a href="#">Add Purchase Requisition</a></li>
  </ul>
</div>

<div class="body-content__wrapper">
  <div class="row">
    <div class="col-sm-12">
      <form method="POST" action="/requisition/store" enctype="multipart/form-data">
        @csrf
        <div class="card">
          <div class="card-header">
            <strong>Add Purchase Requisition</strong>
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
              $gls = ['generalledgerallocation','general leger allocation','gl allocation','GL Allocation','GL','Gl','gl'];

              $filteredFields = $formFields->reject(function ($field) use ($vendorNames) {
                  return in_array(strtolower($field->name), array_map('strtolower', $vendorNames));
              });
            @endphp

            {{-- === Dynamic Form Fields === --}}
            @foreach($formFields->chunk(2) as $fieldPair)
              <div class="row">
                @foreach($fieldPair as $field)
                  <div class="col-md-6">
                    <div class="form-col">
                      @if(in_array($field->name, array_map('strtolower', $invoiceNames)))
                        {{-- Hide label for invoice fields per original behavior --}}
                      @else
                        <label>{{ $field->label }}</label>
                      @endif

                      @php
                        $fieldNameLower = strtolower($field->name);
                      @endphp

                      @if($field->type === 'checkbox')
                        {{-- Render as Yes/No radios (normal size) --}}
                        <div>
                          <label class="me-3">
                            <input type="radio" name="{{ $field->name }}" value="Yes" {{ old($field->name) == 'Yes' ? 'checked' : '' }}>
                            Yes
                          </label>
                          <label>
                            <input type="radio" name="{{ $field->name }}" value="No" {{ old($field->name) == 'No' ? 'checked' : '' }}>
                            No
                          </label>
                        </div>

                      @elseif($field->type === 'dropdown')
                        <select class="form-control" name="{{ $field->name }}" id="{{ $field->name }}">
                          <option value="">-- Select {{ $field->label }} --</option>
                          @if($field->options)
                            @foreach(json_decode($field->options) as $option)
                              <option value="{{ $option }}">{{ $option }}</option>
                            @endforeach
                          @endif
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

                      @elseif(in_array($fieldNameLower, array_map('strtolower', $gls)))
                        <select class="js-example-basic-single form-control" name="{{ $field->name }}">
                          <option value="">Select General Leger</option>
                          @foreach($gl as $gl)
                            <option value="{{ $gl->account }}">{{ $gl->accountDescription }}</option>
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
                        {{-- Keep invoice inputs hidden/handled as before (no change) --}}

                      @else
                        <input
                          type="{{ $field->type === 'integer' ? 'number' : 'text' }}"
                          class="form-control"
                          name="{{ $field->name }}">
                      @endif
                    </div>
                  </div>
                @endforeach
              </div>
            @endforeach

            <hr style="border-color: black;">

            {{-- === Dynamic Upload Section === --}}
<div class="clearfix" id="dynamic_field">
  <div class="row align-items-center" id="row1" style="display:flex; flex-wrap:nowrap; align-items:center; gap:10px;">
    
    <div class="col-sm-2" style="flex:0 0 9%;margin-top:-20px;">
      <label style="font-size:17px;">One-Time?</label>
      <div>
        <input type="hidden" name="is_one_time_vendor[]" id="isOneTimeInput_1" value="no">
        <label class="radio-inline" style="font-size:17px;">
          <input type="radio" name="is_one_time_vendor_1" value="yes" onchange="toggleVendorTypeDynamic(1, this.value)"> Yes
        </label>
        <label class="radio-inline" style="font-size:17px;">
          <input type="radio" name="is_one_time_vendor_1" value="no" checked onchange="toggleVendorTypeDynamic(1, this.value)"> No
        </label>
      </div>
    </div>

    <div class="col-sm-2" style="flex:0 0 16%;">
      <div class="form-col">
        <label style="font-size:13px;">Vendor</label>
        <input type="hidden" name="vendor_final[]" id="finalVendorInput_1">
        <input type="text" class="form-control" id="oneTimeVendorInput_1" style="display:none; margin-top:2px; height:35px;" placeholder="One-Time Vendor Name" oninput="updateFinalVendorValue(1, this.value)">
        <select class="js-example-basic-single form-control" id="vendorDropdown_1" onchange="updateFinalVendorValue(1, this.value)" style="height:35px;">
          <option value="">Select Vendor</option>
          @foreach($vendors as $vendor)
            <option value="{{ $vendor->SupplierName }}">{{ $vendor->SupplierName }}</option>
          @endforeach
        </select>
      </div>
    </div>

    <!-- Three file inputs strictly horizontal -->
    <div class="col-sm-3 d-flex justify-content-between" style="flex:0 0 50%; gap:6px;">
      <div class="form-col" style="flex:1;">
        <label style="font-size:15px;">Quotation</label>
        <input type="file" class="form-control" name="dfile1[]" style="height:45px;" required>
      </div>
      <div class="form-col" style="flex:1;">
        <label style="font-size:15px;">Additional Doc</label>
        <input type="file" class="form-control" name="dfile2[]" style="height:45px;">
      </div>
      <div class="form-col" style="flex:1;">
        <label style="font-size:15px;">Additional Doc</label>
        <input type="file" class="form-control" name="dfile3[]" style="height:45px;">
      </div>
    </div>

    <div class="col-sm-1" style="flex:0 0 9%;">
      <div class="form-col">
        <label style="font-size:13px;">Amount</label>
        <input type="number" step="0.01" class="form-control" name="damount[]" style="height:45px;" required>
      </div>
    </div>

    <div class="col-sm-1 text-right" style="flex:0 0 6%;">
      <button type="button" name="add" id="add" class="btn add-more btn-primary" style="margin-top:-10px; padding:4px 10px;">+ Add</button>
    </div>

    <!-- Hidden vendor detail fields -->
    <input type="hidden" name="bank[]" id="bankInput_1">
    <input type="hidden" name="accountNumber[]" id="accountNumberInput_1">
    <input type="hidden" name="accountType[]" id="accountTypeInput_1">
    <input type="hidden" name="branchCode[]" id="branchCodeInput_1">
    <input type="hidden" name="doc[]" id="docPlaceholder_1">
<input type="file" name="doc_file[]" id="docInput_1" style="display:none;">
<input type="file" name="doc_file2[]" id="docInput2_1" style="display:none;">
<input type="file" name="doc_file3[]" id="docInput3_1" style="display:none;">
  </div>
</div>


            {{-- === Modal for One-Time Vendor Row 1 === --}}
            <div class="modal fade" id="oneTimeVendorModal_1" tabindex="-1" role="dialog" aria-labelledby="oneTimeVendorModalLabel_1" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">One-Time Vendor Details</h5>
                  </div>
                  <div class="modal-body">
                    <div class="form-col">
                      <label>Vendor Name</label>
                      <input type="text" class="form-control" id="modalVendorName_1" placeholder="Vendor Name">
                    </div>
                    <div class="form-col">
                      <label>Type</label>
                      <select class="form-control" name="type[]">
                        <option value="">--Select--</option>
                        @foreach($vendorTypes as $type)
                          <option value="{{ $type->name }}">{{ $type->name }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-col">
                      <label>Vat Allocation</label>
                      <input type="text" class="form-control" name="Vatallocation[]">
                    </div>
                    <div class="form-col">
                      <label>Supplier Code</label>
                      <input type="text" class="form-control" name="supplierCode[]">
                    </div>

                    <div class="form-col">
                      <label>Bank</label>
                      <select class="form-control" id="modalBank_1">
                        <option value="">--Select--</option>
                        @foreach($banks as $bank)
                          <option value="{{ $bank->name }}">{{ $bank->name }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-col">
                      <label>Account Number</label>
                      <input type="text" class="form-control" id="modalAccountNumber_1">
                    </div>
                    <div class="form-col">
                      <label>Account Type</label>
                      <input type="text" class="form-control" id="modalAccountType_1">
                    </div>
                    <div class="form-col">
                      <label>Branch Code</label>
                      <input type="text" class="form-control" id="modalBranchCode_1">
                    </div>

                   <div class="form-col">
                    <label>Upload Document 1</label>
                    <input type="file" class="form-control" id="modaldoc1_1">
                  </div>
                  <div class="form-col">
                    <label>Upload Document 2</label>
                    <input type="file" class="form-control" id="modaldoc2_1">
                  </div>
                  <div class="form-col">
                    <label>Upload Document 3</label>
                    <input type="file" class="form-control" id="modaldoc3_1">
                  </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="saveOneTimeVendorDynamic(1)">Done</button>
                  </div>
                </div>
              </div>
            </div>

            <br>
          </div>

          <div class="card-footer">
            <div class="d-flex justify-content-end">
              <input type="submit" class="btn btn-success" value="Save" style="padding:10px 20px; font-size:16px; min-width:100px;">
              <input type="reset" class="btn btn-danger" value="Cancel" style="padding:10px 20px; font-size:16px; min-width:100px;">
            </div>
          </div>

        </div>
      </form>
    </div>
  </div>
</div>
@endsection

<script type="text/javascript">
$(document).ready(function () {
  // Initialize Select2 only once for existing elements
  $('.js-example-basic-single').select2({
    width: 'resolve'
  });

  let i = 1;
$('#add').click(function () {
  i++;
  const modalId = `oneTimeVendorModal_${i}`;

  // Append the vendor row
  $('#dynamic_field').append(`
    <div class="row align-items-center dynamic-added" id="row${i}" 
         style="display:flex; flex-wrap:nowrap; align-items:center; gap:10px;">
      
      <div class="col-sm-2" style="flex:0 0 9%; margin-top:-20px;">
        <label style="font-size:17px;">One-Time?</label>
        <div>
          <input type="hidden" name="is_one_time_vendor[]" id="isOneTimeInput_${i}" value="no">
          <label class="radio-inline" style="font-size:17px;">
            <input type="radio" name="is_one_time_vendor_${i}" value="yes" onchange="toggleVendorTypeDynamic(${i}, this.value)"> Yes
          </label>
          <label class="radio-inline" style="font-size:17px;">
            <input type="radio" name="is_one_time_vendor_${i}" value="no" onchange="toggleVendorTypeDynamic(${i}, this.value)"> No
          </label>
        </div>
      </div>

      <div class="col-sm-2" style="flex:0 0 16%;">
        <div class="form-col">
          <label style="font-size:13px;">Vendor</label>
          <input type="hidden" name="vendor_final[]" id="finalVendorInput_${i}">
          <input type="text" class="form-control" id="oneTimeVendorInput_${i}" 
                 style="display:none; margin-top:2px; height:35px;" 
                 placeholder="One-Time Vendor Name" 
                 oninput="updateFinalVendorValue(${i}, this.value)">
          <select class="js-example-basic-single form-control vendor-dropdown" 
                  id="vendorDropdown_${i}" 
                  onchange="updateFinalVendorValue(${i}, this.value)" 
                  style="height:35px;">
            <option value="">Select Vendor</option>
            @foreach($vendors as $vendor)
              <option value="{{ $vendor->SupplierName }}">{{ $vendor->SupplierName }}</option>
            @endforeach
          </select>
        </div>
      </div>

      <!-- Three file inputs strictly horizontal -->
      <div class="col-sm-3 d-flex justify-content-between" style="flex:0 0 50%; gap:6px;">
        <div class="form-col" style="flex:1;">
          <label style="font-size:15px;">Quotation</label>
          <input type="file" class="form-control" name="dfile1[]" style="height:45px;" required>
        </div>
        <div class="form-col" style="flex:1;">
          <label style="font-size:15px;">Additional Doc</label>
          <input type="file" class="form-control" name="dfile2[]" style="height:45px;">
        </div>
        <div class="form-col" style="flex:1;">
          <label style="font-size:15px;">Additional Doc</label>
          <input type="file" class="form-control" name="dfile3[]" style="height:45px;">
        </div>
      </div>

      <div class="col-sm-1" style="flex:0 0 9%;">
        <div class="form-col">
          <label style="font-size:13px;">Amount</label>
          <input type="number" step="0.01" class="form-control" name="damount[]" style="height:45px;" required>
        </div>
      </div>

      <div class="col-sm-1 text-right" style="flex:0 0 6%;">
        <button type="button" name="remove" id="${i}" 
                class="btn btn_remove btn-danger" 
                style="margin-top:-10px; padding:4px 10px;">&times;</button>
      </div>

      <!-- Hidden fields -->
      <input type="hidden" name="bank[]" id="bankInput_${i}">
      <input type="hidden" name="accountNumber[]" id="accountNumberInput_${i}">
      <input type="hidden" name="accountType[]" id="accountTypeInput_${i}">
      <input type="hidden" name="branchCode[]" id="branchCodeInput_${i}">
      <input type="hidden" name="doc[]" id="docPlaceholder_${i}">
      <input type="file" name="doc_file[]" id="docInput_${i}" style="display:none;">
      <input type="file" name="doc_file2[]" id="docInput2_${i}" style="display:none;">
<input type="file" name="doc_file3[]" id="docInput3_${i}" style="display:none;">
    </div>
  `);

  // ✅ Append the corresponding modal dynamically
  $('body').append(`
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
            <div class="form-col">
              <label>Vendor Name</label>
              <input type="text" class="form-control" id="modalVendorName_${i}" placeholder="Vendor Name">
            </div>
            <div class="form-col">
              <label>Type</label>
              <select class="form-control" name="type[]">
                <option value="">--Select--</option>
                @foreach($vendorTypes as $type)
                  <option value="{{ $type->name }}">{{ $type->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-col">
              <label>Vat Allocation</label>
              <input type="text" class="form-control" name="Vatallocation[]">
            </div>
            <div class="form-col">
              <label>Supplier Code</label>
              <input type="text" class="form-control" name="supplierCode[]">
            </div>
            <div class="form-col">
              <label>Bank</label>
              <select class="form-control" id="modalBank_${i}">
                <option value="">--Select--</option>
                @foreach($banks as $bank)
                  <option value="{{ $bank->name }}">{{ $bank->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-col">
              <label>Account Number</label>
              <input type="text" class="form-control" id="modalAccountNumber_${i}">
            </div>
            <div class="form-col">
              <label>Account Type</label>
              <input type="text" class="form-control" id="modalAccountType_${i}">
            </div>
            <div class="form-col">
              <label>Branch Code</label>
              <input type="text" class="form-control" id="modalBranchCode_${i}">
            </div>
           <div class="form-col">
            <label>Upload Document 1</label>
            <input type="file" class="form-control" id="modaldoc1_${i}">
          </div>
          <div class="form-col">
            <label>Upload Document 2</label>
            <input type="file" class="form-control" id="modaldoc2_${i}">
          </div>
          <div class="form-col">
            <label>Upload Document 3</label>
            <input type="file" class="form-control" id="modaldoc3_${i}">
          </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="saveOneTimeVendorDynamic(${i})">Done</button>
          </div>
        </div>
      </div>
    </div>
  `);

  // ✅ Initialize Select2 for the new vendor dropdown only
  $(`#vendorDropdown_${i}`).select2({
    width: 'resolve',
    dropdownAutoWidth: true
  }).next('.select2-container').css({
    'max-width': '500px',
    'width': '85%'
  });
});



  // Remove dynamic rows
  $(document).on('click', '.btn_remove', function () {
    const id = $(this).attr("id");
    $('#row' + id).remove();
    $('#oneTimeVendorModal_' + id).remove();
  });
});

function toggleVendorTypeDynamic(index, value) {
  const dropdown = document.getElementById(`vendorDropdown_${index}`);
  const oneTimeInput = document.getElementById(`oneTimeVendorInput_${index}`);
  const modal = $(`#oneTimeVendorModal_${index}`);
  const hiddenIsOneTime = document.getElementById(`isOneTimeInput_${index}`);

  // Select2 container (the visible wrapper)
  const select2Container = $(`#vendorDropdown_${index}`).next('.select2-container');

  if (hiddenIsOneTime) hiddenIsOneTime.value = (value === 'yes') ? 'yes' : 'no';

  if (value === 'yes') {
    // Hide dropdown + its Select2 container smoothly
    if (select2Container.length) select2Container.fadeOut(200);
    $(dropdown).fadeOut(200);

    // Show one-time vendor input with animation
    $(oneTimeInput).fadeIn(250).val('');

    // Clear current vendor and show modal
    updateFinalVendorValue(index, '');
    setTimeout(() => modal.modal('show'), 300);
  } else if (value === 'no') {
    // Hide one-time input smoothly
    $(oneTimeInput).fadeOut(200, function () {
      $(this).val('');
      // Show dropdown and its Select2 container again
      $(dropdown).fadeIn(250);
      if (select2Container.length) select2Container.fadeIn(250);
    });

    // Update final vendor
    updateFinalVendorValue(index, dropdown.value);
  }
}


function saveOneTimeVendorDynamic(index) {
  const requiredFields = [
    { id: `modalVendorName_${index}`, label: 'Vendor Name' },
    { id: `modalBank_${index}`, label: 'Bank' },
    { id: `modalAccountNumber_${index}`, label: 'Account Number' },
    { id: `modalAccountType_${index}`, label: 'Account Type' },
    { id: `modalBranchCode_${index}`, label: 'Branch Code' },
    { id: `modaldoc1_${index}`, label: 'Document 1' },

  ];

  // Check dropdowns or text fields like type, vat allocation, supplier code
  const extraFields = [
    { selector: `#oneTimeVendorModal_${index} select[name='type[]']`, label: 'Type' },
    { selector: `#oneTimeVendorModal_${index} input[name='Vatallocation[]']`, label: 'VAT Allocation' },
    { selector: `#oneTimeVendorModal_${index} input[name='supplierCode[]']`, label: 'Supplier Code' },
  ];

  let missingFields = [];

  // Validate normal inputs
  requiredFields.forEach(f => {
    const el = document.getElementById(f.id);
    if (!el) return;
    if ((el.type === 'file' && (!el.files || el.files.length === 0)) || !el.value.trim()) {
      missingFields.push(f.label);
    }
  });

  // Validate extra fields using jQuery selectors
  extraFields.forEach(f => {
    const val = $(f.selector).val();
    if (!val || val.trim() === '') {
      missingFields.push(f.label);
    }
  });

  // If any missing field found → stop submission
  if (missingFields.length > 0) {
    Swal.fire({
      title: 'Missing Fields',
      html: 'Please fill the following required fields:<br><br><strong>' + missingFields.join(', ') + '</strong>',
      icon: 'warning'
    });
    return;
  }

  // Copy basic vendor details
  const vendorName = document.getElementById(`modalVendorName_${index}`).value;
  const oneTimeInput = document.getElementById(`oneTimeVendorInput_${index}`);
  oneTimeInput.value = vendorName;
  updateFinalVendorValue(index, vendorName);

  // Copy hidden field data
  const bank = getValueById(`modalBank_${index}`);
  const accountNumber = getValueById(`modalAccountNumber_${index}`);
  const accountType = getValueById(`modalAccountType_${index}`);
  const branchCode = getValueById(`modalBranchCode_${index}`);
  setOTVHiddenFields(index, { bank, accountNumber, accountType, branchCode });

  // Copy uploaded files into hidden file inputs
  const modalFile1 = document.getElementById(`modaldoc1_${index}`);
  const modalFile2 = document.getElementById(`modaldoc2_${index}`);
  const modalFile3 = document.getElementById(`modaldoc3_${index}`);
  const hiddenFile1 = document.getElementById(`docInput_${index}`);
  const hiddenFile2 = document.getElementById(`docInput2_${index}`);
  const hiddenFile3 = document.getElementById(`docInput3_${index}`);

  if (modalFile1?.files?.length && hiddenFile1) {
    const dt1 = new DataTransfer();
    dt1.items.add(modalFile1.files[0]);
    hiddenFile1.files = dt1.files;
  }
  if (modalFile2?.files?.length && hiddenFile2) {
    const dt2 = new DataTransfer();
    dt2.items.add(modalFile2.files[0]);
    hiddenFile2.files = dt2.files;
  }
  if (modalFile3?.files?.length && hiddenFile3) {
    const dt3 = new DataTransfer();
    dt3.items.add(modalFile3.files[0]);
    hiddenFile3.files = dt3.files;
  }

  // Close modal after success
  $(`#oneTimeVendorModal_${index}`).modal('hide');

  Swal.fire({
    title: 'Saved!',
    text: 'One-time vendor details captured successfully.',
    icon: 'success',
    timer: 1500,
    showConfirmButton: false
  });
}


function setOTVHiddenFields(index, vals) {
  document.getElementById(`bankInput_${index}`).value = vals.bank ?? '';
  document.getElementById(`accountNumberInput_${index}`).value = vals.accountNumber ?? '';
  document.getElementById(`accountTypeInput_${index}`).value = vals.accountType ?? '';
  document.getElementById(`branchCodeInput_${index}`).value = vals.branchCode ?? '';
}

function getValueById(id) {
  const el = document.getElementById(id);
  return el ? el.value : '';
}

function updateFinalVendorValue(index, value) {
  const finalInput = document.getElementById(`finalVendorInput_${index}`);
  if (finalInput) finalInput.value = value;
}


$(document).ready(function () {
  $('form').on('submit', function (e) {
    e.preventDefault(); // stop immediate submission

    Swal.fire({
      title: 'Are you sure?',
      text: 'Are you sure you have filled in all details?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Yes, Submit',
      cancelButtonText: 'No, Cancel',
      confirmButtonColor: '#28a745',
      cancelButtonColor: '#d33',
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
        // Show loading message (optional)
        Swal.fire({
          title: 'Submitting...',
          text: 'Please wait while we save your data.',
          allowOutsideClick: false,
          didOpen: () => {
            Swal.showLoading();
          }
        });
        // Proceed with form submission
        e.target.submit();
      } else {
        Swal.fire({
          title: 'Cancelled',
          text: 'Submission cancelled.',
          icon: 'info',
          timer: 1500,
          showConfirmButton: false
        });
      }
    });
  });
});
</script>
