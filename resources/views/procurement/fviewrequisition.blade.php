@extends('html.default')

<!-- iCheck CSS -->
<link href="https://cdn.jsdelivr.net/npm/icheck/skins/square/blue.css" rel="stylesheet">

<!-- jQuery (required) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- iCheck JS -->
<script src="https://cdn.jsdelivr.net/npm/icheck/icheck.min.js"></script>

@section('content')

{{-- Top bar with Back button (returns to previous page) --}}
<div class="container-fluid">
  <div class="d-flex justify-content-between align-items-center py-2 mb-3" style="border-bottom: 1px solid #e9ecef;">
    <div>
      <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-">
        <i class="fa fa-arrow-left"></i> Back
      </a>
    </div>
    <div class="text-muted small">
    
    </div>
  </div>
</div>

<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12">
        <form method="POST" action="/procurement/{{$frequisition->id}}/approve">
          @csrf
          @method('put')

          <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
              <strong>Requisition Details</strong>
              <a href="/procurement/indexrequisition" class="btn btn-sm btn-primary">
                <i class="fa fa-align-justify" style="color:white;"></i> Requisitions List
              </a>
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

                @foreach ($formFields as $field)
                  @php
                    $normalizedField = strtolower(trim($field->name));
                  @endphp

                  @continue(in_array($normalizedField, $hiddenFields))

                  @php
                    $value = '';
                    if ($normalizedField === 'department') {
                        $value = $departments->firstWhere('id', $frequisition->department)->name ?? 'Unknown Department';
                    } else {
                        $value = $normalizedRequisition[$normalizedField] ?? '';
                    }
                  @endphp

                  <div class="col-md-6 mb-3">
                    <label class="form-label">{{ $field->label }}</label>
                    <input type="text" class="form-control form-control-sm" value="{{ $value }}" readonly>
                  </div>
                @endforeach
              </div>

              @if($frequisition->reason != null)
                <div class="row">
                  <div class="col-sm-12 col-md-8">
                    <div class="form-group">
                      <label>Reason</label>
                      <textarea class="form-control form-control-sm" name="reason" rows="3" readonly>{{ $frequisition->reason }}</textarea>
                    </div>
                  </div>
                </div>
              @endif
            </div>
          </div>

          <div class="card mt-4 shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
              <div>
                <strong>Vendors</strong>
                <small class="text-muted">List</small>
              </div>
              <small class="text-muted">Select one vendor to enable Approve</small>
            </div>

            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-sm mb-0">
                  <thead class="thead-light">
                    <tr>
                      <th class="text-center" style="width: 80px;">Select</th>
                      <th class="text-center">Vendor Name</th>
                      <th class="text-center" style="width: 160px;">Amount</th>
                      <th class="text-center" style="width: 160px;">Document</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($frequisitionvendors as $faira)
                      <tr>
                        <td class="text-center align-middle">
                          <input type="checkbox"
                                 name="selected_vendor"
                                 value="{{ $faira->id }}"
                                 class="exclusive-checkbox"
                                 {{ $faira->status == 1 ? 'checked' : '' }}>
                        </td>
                        <td class="text-center align-middle">{{ $faira->vendor_final }}</td>
                        <td class="text-center align-middle">R {{ number_format($faira->amount, 2) }}</td>
                        <td class="text-center align-middle">
                          @if (!empty($faira->file_path))
                            <a href="{{ asset('/storage/uploads/' . $faira->file_path) }}" target="_blank" class="btn btn-sm btn-info text-white">
                              View 
                            </a>
                          @else
                            <span class="text-muted small">No document</span>
                          @endif
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>

              @if($frequisition->userId != auth()->user()->id AND $history == NULL AND  $frequisition->status != 6)
                @if($frequisition->approvedby == auth()->user()->userrole AND $frequisition->approvallevel <= $frequisition->totalapprovallevels)
                  <div class="pt-3 d-flex justify-content-end">
                    <div class="btn-group" role="group">
                      <button type="submit" id="submitBtn" class="btn btn-sm btn-success" onclick="celebrate()" disabled>
                        <span class='fa fa-check-circle'></span> Approve
                      </button>
                      <a href="#returnback" data-toggle="modal" class="btn btn-sm btn-outline-primary">
                        <span class='fa fa-arrow-left'></span> Return
                      </a>
                      <a href="#emailCopy" data-toggle="modal" class="btn btn-sm btn-outline-danger">
                        <span class='fa fa-times-circle'></span> Reject
                      </a>
                    </div>
                  </div>
                @endif
              @endif

            </div>
          </div>

          {{-- Modals --}}
          <div class="modal fade" id="emailCopy" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-primary modal-md" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title"><i class="fa fa-envelope" style="color:white;"></i> Reject Purchase Order</h4>
                  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                </div>
                <div class="modal-body" style="font-size: 14px;">
                  <form method="POST" action="/procurement/{{$frequisition->id}}/rejection">
                    @csrf
                    @method('put')
                    <div class="form-group">
                      <label for="reject_message">Reason for rejecting</label>
                      <textarea id="reject_message" rows="3" name="message" class="form-control form-control-sm" maxlength="150" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                  <button class="btn btn-sm btn-secondary" type="button" data-dismiss="modal">Close</button>
                  <button class="btn btn-sm btn-danger" type="submit"><span class='fa fa-times-circle'></span> Reject</button>
                </div>
                  </form>
              </div>
            </div>
          </div>

          <div class="modal fade" id="returnback" tabindex="-1" role="dialog" aria-labelledby="returnModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-primary modal-md" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title"><i class="fa fa-envelope" style="color:white;"></i> Return Purchase Requisition</h4>
                  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                </div>
                <div class="modal-body" style="font-size: 14px;">
                  <form method="POST" action="/procurement/{{$frequisition->id}}/sendbackrequistion">
                    @csrf
                    @method('put')
                    <div class="form-group">
                      <label for="return_message">Reason for Returning</label>
                      <textarea id="return_message" rows="3" name="message" class="form-control form-control-sm" maxlength="150" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                  <button class="btn btn-sm btn-secondary" type="button" data-dismiss="modal">Close</button>
                  <button class="btn btn-sm btn-primary" type="submit"><span class='fa fa-arrow-left'></span> Return</button>
                </div>
                  </form>
              </div>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>

@endsection

@if(session('approved'))
  <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    window.addEventListener('DOMContentLoaded', function () {
      Swal.fire({
        title: 'Approved!',
        text: 'Your request was successfully approved.',
        icon: 'success',
        timer: 2500,
        showConfirmButton: false
      });
      setTimeout(() => {
        confetti({
          particleCount: 100,
          spread: 70,
          origin: { y: 0.6 }
        });
      }, 500);
    });
  </script>
@endif

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('.exclusive-checkbox');
    const form = document.querySelector('form');
    const submitBtn = document.getElementById('submitBtn');

    function enforceSingleSelection(selected) {
      checkboxes.forEach(cb => {
        if (cb !== selected) cb.checked = false;
      });
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

    if (form) {
      form.addEventListener('submit', function (e) {
        const isChecked = Array.from(checkboxes).some(cb => cb.checked);
        if (!isChecked) {
          e.preventDefault();
          alert('You must select exactly one vendor.');
        }
      });
    }
  });
</script>
