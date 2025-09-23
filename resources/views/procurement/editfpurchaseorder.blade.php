@extends('html.default')

{{-- Bootstrap + SweetAlert2 --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script defer src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

@section('content')
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12">

        <form method="POST" action="/purchaseorder/update/{{ $purchaseorder->id }}" enctype="multipart/form-data" id="mainForm">
          @csrf
          @method('put')

          <div class="card">
            <div class="card-header d-flex align-items-center">
              <strong>View Purchase Order</strong>
              <a href="/procurement/indexrequisition" class="btn btn-primary btn-sm ms-auto">
                <i class="fa fa-align-justify text-white"></i> Requisitions List
              </a>
            </div>

@php
  $vendorNames = ['vendor', 'vendor list', 'vendors', 'Vendor', 'Vendor List'];
  $propertyNames = ['property', 'properties', 'Property List', 'property list'];
  $serviceNames = ['service', 'service list', 'services', 'Service List'];
  $taxtypeNames = ['Tax', 'Tax Type', 'taxtype', 'tax list', 'Tax List'];
  $paymentmethodNames = ['payment method', 'Payment Method', 'payment', 'paymentmethod'];
  $transactionNames = ['transaction', 'transaction list', 'transactions', 'transaction description'];
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
                      <input type="text" class="form-control" id="amount_field" name="{{ $fieldName }}" value="{{ $value }}" readonly>
                    </div>

                  @elseif(in_array($fieldName, array_map('strtolower', $invoiceamount)))
                    <div class="col-md-6 mb-3">
                      <label class="form-label">{{ $field->label }}</label>
                      <input type="number" class="form-control" id="invoice_amount_field" name="{{ $fieldName }}" value="{{ $value }}" step="0.01" min="0">
                    </div>

                  @elseif(in_array($fieldName, array_map('strtolower', $departmentNames)))
                    <div class="col-md-6 mb-3">
                      <label class="form-label">{{ $field->label }}</label>
                      <input type="text" class="form-control" name="{{ $fieldName }}" value="{{ $departments->name ?? 'Unknown' }}" readonly>
                    </div>

                  @else
                    <div class="col-md-6 mb-3">
                      <label class="form-label">{{ $field->label }}</label>
                      <input type="text" class="form-control" name="{{ $fieldName }}" value="{{ $value }}" readonly>
                    </div>
                  @endif
                @endforeach

                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Beneficiary Reference</label>
                    <input type="text" class="form-control" name="benref">
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Own Reference</label>
                    <input type="text" class="form-control" name="ownref">
                  </div>
                </div>

                @if ($purchaseorder->status == 4 OR $purchaseorder->status == 3 )
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Reason for Return</label>
                      <input type="text" class="form-control" name="reason" value="{{ $purchaseorder->reason }}" readonly>
                    </div>
                  </div>
                @endif

                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Upload Invoice</label>
                    <input type="file" class="form-control" id="invoice_file" name="invoice" aria-label="Upload" required>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Upload Job Card</label>
                    <input type="file" class="form-control" id="jobcard_file" name="jobcard" aria-label="Upload">
                  </div>
                </div>
              </div>

              <!-- Hidden container for dynamic items -->
              <div id="hiddenItemsContainer" style="display: none;"></div>
            </div>

            <hr class="border-2 border-dark opacity-100">

            <div class="card-footer">
              <div class="form-group pull-right">
                <input type="submit" class="btn btn-success" value="Save"/>
              </div>
            </div>

          </div> {{-- /.card --}}

          {{-- ===== Items Summary (read-only mirror of modal table) ===== --}}
          <div class="card mt-3" id="itemsPreviewCard" style="display:none;">
            <div class="card-header bg-light">
              <strong>Itemized Purchase Order — Summary</strong>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="itemsPreviewTable">
                  <thead class="table-light">
                    <tr>
                      <th>Item</th>
                      <th>Description</th>
                      <th>Quantity</th>
                      <th>Price/Item</th>
                      <th>Vat Type</th>
                      <th>Line Total</th>
                      <th>VAT Amount</th>
                    </tr>
                  </thead>
                  <tbody id="itemsPreviewBody"></tbody>
                  <tfoot>
                    <tr class="table-light">
                      <td colspan="5" class="text-end fw-bold">Sum Line Total</td>
                      <td>
                        <input type="number" id="preview_sum_linetotal" class="form-control" step="0.01" readonly />
                      </td>
                      <td></td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>

        </form>

      </div>
    </div>
  </div>
</div>

<!-- ===== Modal: Itemized Purchase Order ===== -->
<div class="modal fade" id="customFormModal" tabindex="-1" aria-labelledby="customFormModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
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
                <th>Vat Type</th>
                <th>Line Total</th>
                <th>VAT Amount</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="itemTableBody">
              <tr>
                <td><input type="text" name="items[0][item]" class="form-control item-input" /></td>
                <td><input type="text" name="items[0][description]" class="form-control item-input" /></td>
                <td><input type="number" name="items[0][quantity]" class="form-control item-input calc-field" /></td>
                <td><input type="number" name="items[0][price]" class="form-control item-input calc-field" step="0.01" /></td>
                <td>
                  <select name="items[0][weight]" class="form-control item-input">
                    <option value="1">1</option>
                    <option value="5">5</option>
                  </select>
                </td>
                <td><input type="number" name="items[0][linetotal]" class="form-control item-input" step="0.01" readonly /></td>
                <td><input type="number" name="items[0][vat]" class="form-control item-input" step="0.01" readonly /></td>
                <td><button type="button" class="btn btn-danger btn-sm remove-row">Remove</button></td>
              </tr>
            </tbody>
            <tfoot>
              <tr class="table-light">
                <td colspan="5" class="text-end fw-bold">Sum Line Total</td>
                <td>
                  <input type="number" id="sum_linetotal" class="form-control" step="0.01" readonly />
                </td>
                <td></td>
                <td></td>
              </tr>
            </tfoot>
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
(function() {
  // wait for DOM
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

  function init() {
    // bail early if modal missing
    const modalEl = document.getElementById('customFormModal');
    if (!modalEl) return;

    // bootstrap modal instance (safe even if called twice)
    const modal = new bootstrap.Modal(modalEl);

    const checkbox = document.getElementById('customModalTrigger');
    const itemTableBody = document.getElementById('itemTableBody');
    const hiddenItemsContainer = document.getElementById('hiddenItemsContainer');
    const sumLineTotalInput = document.getElementById('sum_linetotal');
    const invoiceInput = document.getElementById('invoice_amount_field');
    const amountField  = document.getElementById('amount_field');

    const itemsPreviewCard = document.getElementById('itemsPreviewCard');
    const itemsPreviewBody = document.getElementById('itemsPreviewBody');
    const previewSumLineTotalInput = document.getElementById('preview_sum_linetotal');

    // open modal via checkbox
    if (checkbox) {
      checkbox.addEventListener('change', () => { if (checkbox.checked) modal.show(); });
    }
    modalEl.addEventListener('hidden.bs.modal', () => { if (checkbox) checkbox.checked = false; });

    // helpers
    function reindexRows() {
      itemTableBody.querySelectorAll('tr').forEach((row, i) => {
        row.querySelectorAll('input, select').forEach(inp => {
          if (/\bitems\[\d+\]/.test(inp.name)) inp.name = inp.name.replace(/items\[\d+\]/, `items[${i}]`);
        });
      });
    }
    function updateSumAndInvoice() {
      let sum = 0;
      itemTableBody.querySelectorAll('input[name*="[linetotal]"]').forEach(inp => {
        const v = parseFloat(inp.value); if (!isNaN(v)) sum += v;
      });
      if (sumLineTotalInput) sumLineTotalInput.value = sum.toFixed(2);
      if (invoiceInput)      invoiceInput.value      = sum.toFixed(2);
    }
    function calculateRow(row) {
      const q = parseFloat(row.querySelector('[name*="[quantity]"]')?.value) || 0;
      const p = parseFloat(row.querySelector('[name*="[price]"]')?.value)    || 0;
      const w = parseInt(row.querySelector('[name*="[weight]"]')?.value || '1', 10);
      const lt = row.querySelector('[name*="[linetotal]"]');
      const vt = row.querySelector('[name*="[vat]"]');
      const lineTotal = q * p;
      let vat = 0;
      if (w === 1 && p > 0) vat = (lineTotal * 15) / 115; // inclusive VAT extraction
      if (lt) lt.value = lineTotal.toFixed(2);
      if (vt) vt.value = vat.toFixed(2);
      updateSumAndInvoice();
      queuePreviewRender();
    }
    function attachCalc(row) {
      row.querySelectorAll('[name*="[quantity]"],[name*="[price]"],[name*="[weight]"]').forEach(el => {
        el.addEventListener('input', () => calculateRow(row));
        el.addEventListener('change', () => calculateRow(row));
      });
    }
    function addRow() {
      const i = itemTableBody.querySelectorAll('tr').length;
      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td><input type="text"   name="items[${i}][item]"        class="form-control item-input"></td>
        <td><input type="text"   name="items[${i}][description]" class="form-control item-input"></td>
        <td><input type="number" name="items[${i}][quantity]"    class="form-control item-input"></td>
        <td><input type="number" name="items[${i}][price]"       class="form-control item-input" step="0.01"></td>
        <td>
          <select name="items[${i}][weight]" class="form-control item-input">
            <option value="1">1</option>
            <option value="5">5</option>
          </select>
        </td>
        <td><input type="number" name="items[${i}][linetotal]" class="form-control item-input" step="0.01" readonly></td>
        <td><input type="number" name="items[${i}][vat]"       class="form-control item-input" step="0.01" readonly></td>
        <td><button type="button" class="btn btn-danger btn-sm remove-row">Remove</button></td>
      `;
      itemTableBody.appendChild(tr);
      reindexRows();
      attachCalc(tr);
      calculateRow(tr);
    }
    function transferHidden() {
      hiddenItemsContainer.innerHTML = '';
      itemTableBody.querySelectorAll('tr').forEach(row => {
        row.querySelectorAll('.item-input').forEach(field => {
          const input = document.createElement('input');
          input.type  = 'hidden';
          input.name  = field.name;
          input.value = field.value;
          hiddenItemsContainer.appendChild(input);
        });
      });
    }
    // preview (debounced)
    let previewQueued = false;
    function escapeHtml(s){return String(s??'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/'/g,'&#039;');}
    function renderPreview() {
      if (!itemsPreviewBody) return;
      itemsPreviewBody.innerHTML = '';
      let sum = 0;
      itemTableBody.querySelectorAll('tr').forEach(row => {
        const get = sel => row.querySelector(sel)?.value ?? '';
        const linetotal = parseFloat(get('[name*="[linetotal]"]') || '0') || 0;
        const tr = document.createElement('tr');
        tr.innerHTML = `
          <td>${escapeHtml(get('[name*="[item]"]'))}</td>
          <td>${escapeHtml(get('[name*="[description]"]'))}</td>
          <td>${escapeHtml(get('[name*="[quantity]"]'))}</td>
          <td>${escapeHtml(get('[name*="[price]"]'))}</td>
          <td>${escapeHtml(row.querySelector('[name*="[weight]"]')?.value || '')}</td>
          <td>${linetotal.toFixed(2)}</td>
          <td>${escapeHtml(get('[name*="[vat]"]') || '0.00')}</td>
        `;
        itemsPreviewBody.appendChild(tr);
        sum += linetotal;
      });
      if (previewSumLineTotalInput) previewSumLineTotalInput.value = sum.toFixed(2);
      if (itemsPreviewCard) itemsPreviewCard.style.display = itemsPreviewBody.children.length ? '' : 'none';
    }
    function queuePreviewRender(){
      if (previewQueued) return;
      previewQueued = true;
      Promise.resolve().then(() => { previewQueued = false; renderPreview(); });
    }

    // ensure first row is wired
    (function setupFirstRow(){
      const first = itemTableBody.querySelector('tr');
      if (!first) return;
      first.querySelector('[name*="[linetotal]"]')?.setAttribute('readonly','readonly');
      first.querySelector('[name*="[vat]"]')?.setAttribute('readonly','readonly');
      attachCalc(first);
      calculateRow(first);
    })();

    // ⚡️ EVENT DELEGATION: catch clicks from *inside* the modal anywhere
    modalEl.addEventListener('click', (e) => {
      // Add Row
      if (e.target.id === 'addRowBtn' || e.target.closest('#addRowBtn')) {
        addRow();
      }
      // Save Items
      if (e.target.id === 'saveItemsBtn' || e.target.closest('#saveItemsBtn')) {
        itemTableBody.querySelectorAll('tr').forEach(calculateRow);
        updateSumAndInvoice();
        transferHidden();
        queuePreviewRender();
        modal.hide();
      }
      // Remove row
      if (e.target.classList.contains('remove-row') || e.target.closest('.remove-row')) {
        const row = e.target.closest('tr');
        if (itemTableBody.querySelectorAll('tr').length > 1) {
          row.remove();
          reindexRows();
          updateSumAndInvoice();
          queuePreviewRender();
        } else {
          Swal.fire({icon:'info', title:'Heads up', text:'At least one item row must remain.'});
        }
      }
    });

    // initial preview
    queuePreviewRender();
  }
})();
</script>
