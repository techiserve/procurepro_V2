@extends('html.default')

{{-- Bootstrap 5 (remove if already included in your layout) --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- iCheck CSS (optional) -->
<link href="https://cdn.jsdelivr.net/npm/icheck/skins/square/blue.css" rel="stylesheet">
<!-- jQuery (optional; only needed if you use iCheck/UI relying on it) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- iCheck JS (optional) -->
<script src="https://cdn.jsdelivr.net/npm/icheck/icheck.min.js"></script>
<style>
  .modal-body label {
    font-weight: 600;
  }
</style>
@section('content')

@php
  $prev = url()->previous();
  $fallback = route('procurement.indexrequisition');
  $backUrl = ($prev && str_starts_with($prev, url('/'))) ? $prev : $fallback;
@endphp

<!-- TOP: Back button (previous page) -->
<div class="container-fluid">
  <div class="py-2">
    <a href="{{ $backUrl }}" class="btn btn-outline-secondary btn-sm">
      <i class="fa fa-arrow-left"></i> Back
    </a>
  </div>
</div>

<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12">

        {{-- APPROVE form wraps both cards --}}
        <form method="POST" action="/procurement/{{ $frequisition->id }}/approve">
          @csrf
          @method('put')

          {{-- Card 1: Requisition details --}}
          <div class="card mb-3">
            <div class="card-header">
              <div class="d-flex justify-content-between align-items-center">
                <strong>View Requisition</strong>
                <a href="/procurement/indexrequisition" class="btn btn-primary btn-sm text-white">
                  <i class="fa fa-align-justify"></i> Requisitions List
                </a>
              </div>
            </div>

            <div class="card-body">
              <div class="row">
                @php
                  $normalizedRequisition = [];
                  foreach ($frequisition->getAttributes() as $key => $value) {
                    $normalizedRequisition[strtolower(trim($key))] = $value;
                  }
                  $hiddenFields = ['invoiceamount', 'invoice amount'];
                @endphp

                @foreach(($formFields ?? []) as $field)
                  @php $normalizedField = strtolower(trim($field->name)); @endphp
                  @continue(in_array($normalizedField, $hiddenFields))

                  @php
                    if ($normalizedField === 'department') {
                      $value = ($departments ?? collect())->firstWhere('id', $frequisition->department)->name ?? 'Unknown Department';
                    } else {
                      $value = $normalizedRequisition[$normalizedField] ?? '';
                    }
                  @endphp

                  <div class="col-md-6 mb-3">
                    <label class="form-label">{{ $field->label }}</label>
                    <input type="text" class="form-control" value="{{ $value }}" readonly>
                  </div>
                @endforeach
              </div>

              @if($frequisition->reason != null)
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="reason">Reason</label>
                      <textarea id="reason" class="form-control" name="reason" rows="3" readonly>{{ $frequisition->reason }}</textarea>
                    </div>
                  </div>
                </div>
              @endif
            </div>
          </div>

          {{-- Card 2: Vendors list + action buttons --}}
          <div class="card">
            <div class="card-header">
              <strong>Vendors</strong>
              <small class="text-muted ms-2">List</small>
            </div>

            <div class="card-body">
              <div class="table-responsive">
                 
                <table class="table table-bordered table-striped table-sm align-middle">
                  <thead>
                    <tr>
                      <th class="text-center" style="width: 80px;">Select</th>
                      <th class="text-center">Vendor Name</th>
                      <th class="text-center">Amount</th>
                      <th class="text-center">Document</th>
                    </tr>
                  </thead>
                   @foreach ($frequisitionvendors as $faira)
                  <tbody>
                  
                      <tr>
                        <td class="text-center">
                          <input type="checkbox"
                                 name="selected_vendor"
                                 value="{{ $faira->id }}"
                                 class="exclusive-checkbox form-check-input"
                                 {{ $faira->status == 1 ? 'checked' : '' }}>
                        </td>
                        <td class="text-center">{{ $faira->vendor_final }}</td>
                        <td class="text-center">R {{ number_format($faira->amount, 2) }}</td>
                        <td class="text-center">
                          @if (!empty($faira->file_path))
                            <a href="{{ asset('/storage/uploads/' . $faira->file_path) }}" target="_blank" class="btn btn-info btn-sm text-white">
                              View Document
                            </a>
            
                          @endif
                               
                          @if($faira->IsOneTimeVendor == 'yes')                                  
                         <button type="button"
                                class="btn btn-success btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#vendorModal_{{ $faira->id }}">
                          View Vendor Details
                        </button>
                        @endif

                        </td>
                      </tr>
                
                  </tbody>

<!-- Vendor Details Modal for Vendor ID: {{ $faira->id }} -->
<div class="modal fade" id="vendorModal_{{ $faira->id }}" tabindex="-1" aria-labelledby="vendorModalLabel_{{ $faira->id }}" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="vendorModalLabel_{{ $faira->id }}">
          Vendor Details - {{ $faira->vendor_final }}
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Vendor Name</label>
            <input type="text" class="form-control" value="{{ $faira->vendor_final }}" readonly>
          </div>

          <div class="col-md-6">
            <label class="form-label">Bank</label>
            <input type="text" class="form-control" value="{{ $faira->bank ?? 'N/A' }}" readonly>
          </div>

          <div class="col-md-6">
            <label class="form-label">Account Number</label>
            <input type="text" class="form-control" value="{{ $faira->account_number ?? 'N/A' }}" readonly>
          </div>

          <div class="col-md-6">
            <label class="form-label">Account Type</label>
            <input type="text" class="form-control" value="{{ $faira->account_type ?? 'N/A' }}" readonly>
          </div>

          <div class="col-md-6">
            <label class="form-label">Branch Code</label>
            <input type="text" class="form-control" value="{{ $faira->branchCode ?? 'N/A' }}" readonly>
          </div>
        </div>

        <hr>
        <div class="text-center">
          @if (!empty($faira->doc_path))
            <a href="{{ asset('/storage/uploads/' . $faira->doc_path) }}" target="_blank" class="btn btn-info text-white">
              <i class="fa fa-file"></i> View Vendor Document
            </a>
          @else
            <span class="text-muted">No vendor document available.</span>
          @endif
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          Close
        </button>
      </div>
    </div>
  </div>
</div>

                   @endforeach 
                </table>              
              </div>
            </div>

            @if($frequisition->userId != auth()->user()->id  && $frequisition->status != 6)
              @if($frequisition->approvedby == auth()->user()->userrole && $frequisition->approvallevel <= $frequisition->totalapprovallevels)
                <div class="card-footer d-flex justify-content-end gap-2">
                  <button type="submit" id="submitBtn" class="btn btn-success" disabled>
                    <span class="fa fa-check-circle"></span> Approve
                  </button>

                  {{-- Modal triggers (Bootstrap 5) --}}
                  <button type="button" class="btn btn-info text-white" data-bs-toggle="modal" data-bs-target="#returnback">
                    <span class="fa fa-arrow-left"></span> Return
                  </button>

                  <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#emailCopy">
                    <span class="fa fa-times-circle"></span> Reject
                  </button>
                </div>
              @endif
            @endif
          </div>
        </form>

      </div>
    </div>
  </div>
</div>

{{-- ======= MODALS (outside of the approve form) ======= --}}

{{-- Reject modal --}}
<div class="modal fade" id="emailCopy" tabindex="-1" aria-labelledby="emailCopyLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content">
      <form method="POST" action="/procurement/{{ $frequisition->id }}/rejection">
        @csrf
        @method('put')

        <div class="modal-header">
          <h4 class="modal-title" id="emailCopyLabel">
            <i class="fa fa-envelope"></i> Reject Purchase Order
          </h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body" style="font-size:14px;">
          <div class="form-group">
            <label for="reject_message">Reason for rejecting</label>
            <textarea id="reject_message" name="message" rows="3" class="form-control" maxlength="150" required></textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
          <button class="btn btn-danger" type="submit">
            <span class="fa fa-times-circle"></span> Reject
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Return modal --}}
<div class="modal fade" id="returnback" tabindex="-1" aria-labelledby="returnbackLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content">
      <form method="POST" action="/procurement/{{ $frequisition->id }}/sendbackrequistion">
        @csrf
        @method('put')

        <div class="modal-header">
          <h4 class="modal-title" id="returnbackLabel">
            <i class="fa fa-envelope"></i> Return Purchase Requisition
          </h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body" style="font-size:14px;">
          <div class="form-group">
            <label for="return_message">Reason for Returning</label>
            <textarea id="return_message" name="message" rows="3" class="form-control" maxlength="150" required></textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
          <button class="btn btn-primary" type="submit">
            <span class="fa fa-arrow-left"></span> Return
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

{{-- ======= Page JS ======= --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
  // Single selection among vendor checkboxes
  const checkboxes = document.querySelectorAll('.exclusive-checkbox');
  const submitBtn  = document.getElementById('submitBtn');

  function enforceSingleSelection(selected) {
    checkboxes.forEach(cb => { if (cb !== selected) cb.checked = false; });
  }
  function updateSubmitButtonState() {
    const isChecked = Array.from(checkboxes).some(cb => cb.checked);
    if (submitBtn) submitBtn.disabled = !isChecked;
  }

  updateSubmitButtonState();

  checkboxes.forEach(cb => {
    cb.addEventListener('change', function () {
      enforceSingleSelection(this);
      updateSubmitButtonState();
    });
  });

  // OPTIONAL: if using iCheck, initialize it here (and keep the logic above in sync)
  // $('.exclusive-checkbox').iCheck({
  //   checkboxClass: 'icheckbox_square-blue',
  // }).on('ifChecked', function () {
  //   $('.exclusive-checkbox').not(this).iCheck('uncheck');
  //   updateSubmitButtonState();
  // }).on('ifUnchecked', function () {
  //   updateSubmitButtonState();
  // });
});
</script>
