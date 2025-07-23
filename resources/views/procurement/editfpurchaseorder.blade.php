@extends('stack.layouts.admin')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<!-- SweetAlert2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
@section('content')
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12">
    <form method="POST" action="/purchaseorder/update/{{$purchaseorder->id}}" enctype="multipart/form-data" id="mainForm">
       @csrf
       @method('put')
          <div class="card">
          <div class="card-header">
            <strong>View Purchase Order</strong>
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
          $invoiceamount = ['invoiceamount', 'Invoiceamount','invoice amount'];
@endphp
           <div class="card-body">
        <div class="row">
          <div class="col-md-12 mb-3">
            <div class="form-check form-switch" style="margin-left: 26px;">
              <input class="form-check-input" type="checkbox" role="switch"
                    name="manageusers" value="Manage Users"
                    id="customModalTrigger" />
              <label class="form-check-label" for="customModalTrigger">
                Is this an itemized Purchase Order?
              </label>
            </div>
          </div>

            @foreach ($formFields as $field)

            @php
            $normalizedAttributes = collect($purchaseorder->getAttributes())
             ->keyBy(fn($v, $k) => strtolower($k));

            $fieldName = strtolower($field->name);
            $value = $normalizedAttributes[$fieldName] ?? '';
            @endphp
                 
                @if(in_array($fieldName, array_map('strtolower', $paymentmethodNames)))
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ $field->label }}</label>
                   <input type="text" class="form-control" name="{{ $fieldName }}" value="{{ $value }}" readonly>
                </div>
                @elseif(in_array($fieldName, array_map('strtolower', $amount)))
                   <div class="col-md-6 mb-3">
                    <label class="form-label">{{ $field->label }}</label>
                    <input type="text" class="form-control" name="{{ $fieldName }}" value="{{ $value }}" readonly>
                </div>
                   @elseif(in_array($fieldName, array_map('strtolower', $invoiceamount)))
                   <div class="col-md-6 mb-3">
                    <label class="form-label">{{ $field->label }}</label>
                    <input type="text" class="form-control" name="{{ $fieldName }}" value="{{ $value }}" >
                </div>
                    @elseif(in_array($fieldName, array_map('strtolower', $departmentNames)))
                   <div class="col-md-6 mb-3">
                   <label class="form-label">{{ $field->label }}</label>
                   <input type="text" class="form-control" name="{{ $fieldName }}" value="{{ $departments->name ?? 'Unknown' }}" readonly>
                </div>
                @else
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ $field->label }}</label>
                    <input type="text" class="form-control"  name="{{ $fieldName }}" value="{{ $value }}" readonly>
                </div>
                @endif
            @endforeach
   {{--  --}}
             <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_number">Beneficiary Reference</label>
                  <input type="text" class="form-control" name="benref" aria-describedby="inputGroupFileAddon04" >
                </div>
              </div>    

             <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_number">Own Reference</label>
                  <input type="text" class="form-control" name="ownref" aria-describedby="inputGroupFileAddon04" >
                </div>
              </div> 
              
              
        

        @if ($purchaseorder->status == 4 OR $purchaseorder->status == 3 )
       
        <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_number">Reason for Return</label>
                  <input type="text" class="form-control" id="inputGroupFile04" name="reason" aria-describedby="inputGroupFileAddon04" value="{{$purchaseorder->reason}}" aria-label="Upload" readonly>
                </div>
              </div>    
        
        </div>
         @endif

          
        <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_number">Upload Invoice</label>
                  <input type="file" class="form-control" id="inputGroupFile04" name="invoice" aria-describedby="inputGroupFileAddon04" aria-label="Upload" required>
                </div>
              </div>    
        

        <div class="col-sm-6">
          <div class="form-group">
            <label for="grower_number">Upload Job Card</label>
            <input type="file" class="form-control" id="inputGroupFile04" name="jobcard" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
          </div>
        </div>    

        </div>

        <!-- Hidden container for dynamic items -->
        <div id="hiddenItemsContainer" style="display: none;"></div>

      </div>
      
			<hr style="border-color: black;">
			<br>
         
         
            <div class="card-footer">
            <div class="form-group pull-right">
    				
             <input type="submit" class="btn btn-success" value="Save"/>

    			</div> 
          </div>
      
          
       </div>
    </form>
    </div>
      
  
</div>
</div>


</div>


</div>


<!-- Modal -->
<div class="modal fade" id="customFormModal" tabindex="-1" aria-labelledby="customFormModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="customFormModalLabel">Itemized Purchase Order</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="modalCloseBtn"></button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="itemTable">
            <thead class="table-light">
              <tr>
                <th>Item</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Price/Item</th>
                <th>Total Weight</th>
                 <th>Line Total</th>
                <th>VAT Amount</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="itemTableBody">
              <tr>
                <td><input type="text" name="items[0][item]" class="form-control item-input" /></td>
                <td><input type="text" name="items[0][description]" class="form-control item-input" /></td>
                <td><input type="number" name="items[0][quantity]" class="form-control item-input" /></td>
                <td><input type="number" name="items[0][price]" class="form-control item-input" step="0.01" /></td>
                <td><input type="number" name="items[0][weight]" class="form-control item-input" step="0.01" /></td>
                <td><input type="number" name="items[0][linetotal]" class="form-control item-input" step="0.01" /></td>
                <td><input type="number" name="items[0][vat]" class="form-control item-input" step="0.01" /></td>
                <td><button type="button" class="btn btn-danger btn-sm remove-row">Remove</button></td>
              </tr>
            </tbody>
          </table>
        </div>
        <button type="button" class="btn btn-secondary" id="addRowBtn">Add Row</button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="saveItemsBtn">Save Items</button>
        <button type="button" class="btn btn-secondary" id="closeModalBtn">Close</button>
      </div>
    </div>
  </div>
</div>

@endsection

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const checkbox = document.getElementById('customModalTrigger');
    const modalElement = document.getElementById('customFormModal');
    const modal = new bootstrap.Modal(modalElement);
    const closeBtn = document.getElementById('closeModalBtn');
    const modalCloseBtn = document.getElementById('modalCloseBtn');
    const itemTableBody = document.getElementById('itemTableBody');
    const addRowBtn = document.getElementById('addRowBtn');
    const saveItemsBtn = document.getElementById('saveItemsBtn');
    const hiddenItemsContainer = document.getElementById('hiddenItemsContainer');
    const mainForm = document.getElementById('mainForm');

    // Show modal when checkbox is checked
    checkbox.addEventListener('change', function () {
      if (checkbox.checked) {
        modal.show();
      }
    });

    // Handle modal close
    modalElement.addEventListener('hidden.bs.modal', function () {
      checkbox.checked = false;
    });

    // Reindex all item row inputs after any add/remove
    function reindexRows() {
      const rows = itemTableBody.querySelectorAll('tr');
      rows.forEach((row, index) => {
        row.querySelectorAll('input').forEach(input => {
          const name = input.name;
          const newName = name.replace(/items\[\d+\]/, `items[${index}]`);
          input.name = newName;
        });
      });
    }

    // Add new dynamic row
    addRowBtn.addEventListener('click', function () {
      const rowCount = itemTableBody.querySelectorAll('tr').length;
      const newRow = document.createElement('tr');
      newRow.innerHTML = `
        <td><input type="text" name="items[${rowCount}][item]" class="form-control item-input" /></td>
        <td><input type="text" name="items[${rowCount}][description]" class="form-control item-input" /></td>
        <td><input type="number" name="items[${rowCount}][quantity]" class="form-control item-input" /></td>
        <td><input type="number" name="items[${rowCount}][price]" class="form-control item-input" step="0.01" /></td>
        <td><input type="number" name="items[${rowCount}][weight]" class="form-control item-input" step="0.01" /></td>
        <td><input type="number" name="items[${rowCount}][linetotal]" class="form-control item-input" step="0.01" /></td>
        <td><input type="number" name="items[${rowCount}][vat]" class="form-control item-input" step="0.01" /></td>
        <td><button type="button" class="btn btn-danger btn-sm remove-row">Remove</button></td>
      `;
      itemTableBody.appendChild(newRow);
      reindexRows();
    });

    // Remove a row and reindex
    itemTableBody.addEventListener('click', function (e) {
      if (e.target.classList.contains('remove-row')) {
        const row = e.target.closest('tr');
        // Don't allow removal of the last row
        if (itemTableBody.querySelectorAll('tr').length > 1) {
          row.remove();
          reindexRows();
        } else {
          alert('At least one item row must remain.');
        }
      }
    });

    // Save items and transfer to hidden form
    saveItemsBtn.addEventListener('click', function () {
      transferItemsToHiddenForm();
      modal.hide();
    });

    // Transfer items from modal to hidden form inputs
    function transferItemsToHiddenForm() {
      // Clear existing hidden inputs
      hiddenItemsContainer.innerHTML = '';
      
      // Get all rows from the modal table
      const rows = itemTableBody.querySelectorAll('tr');
      
      rows.forEach((row, index) => {
        const inputs = row.querySelectorAll('input.item-input');
        
        inputs.forEach(input => {
          // Create hidden input for each field
          const hiddenInput = document.createElement('input');
          hiddenInput.type = 'hidden';
          hiddenInput.name = input.name;
          hiddenInput.value = input.value;
          hiddenItemsContainer.appendChild(hiddenInput);
        });
      });
    }

    // Before form submission, ensure items are transferred
    mainForm.addEventListener('submit', function (e) {
      if (checkbox.checked) {
        transferItemsToHiddenForm();
      }
    });

    // Close modal handlers
    [closeBtn, modalCloseBtn].forEach(btn => {
      btn.addEventListener('click', function () {
        modal.hide();
      });
    });
  });
</script>