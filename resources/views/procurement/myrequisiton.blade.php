@extends('html.default')

{{-- Styles --}}
<link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/tutorials/timelines/timeline-7/assets/css/timeline-7.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
  /* Keep action buttons on one line even when the table scrolls */
  th.actions, td.actions { white-space: nowrap; }
  td.actions { min-width: 360px; } /* adjust if you have more/less buttons */
</style>

@section('content')
<div class="body-content__header">
  <ul>
    <li><a href="#">Requisitions</a></li>
    <li class="ms-auto"></li>
  </ul>
</div>

<div class="body-content__wrapper requesition-body">
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <strong>Requisitions</strong>
      <div class="d-flex align-items-center gap-2">
        {{-- Filter --}}
        <button class="btn btn-primary btn-sm"
                data-bs-toggle="modal" data-bs-target="#filterModal"
                style="padding:10px 20px; font-size:16px; min-width:120px;">
          <i class="fa fa-filter"></i> Filter
        </button>

        {{-- Header Download form (will collect selected checkboxes from the table) --}}
        <form method="POST" action="{{ route('procurement.downloadrequisitions') }}" id="headerDownloadForm" class="m-0">
          @csrf
          <div id="downloadHiddenInputs"></div>
          <button type="submit" class="btn btn-success btn-sm"
                  id="downloadBtnHeader"
                  style="padding:10px 20px; font-size:16px; min-width:120px;">
            <i class="fa fa-download"></i> Download
          </button>
        </form>
      </div>
    </div>

    <div class="card-body">
      {{-- Table form: holds the checkboxes in the table --}}
      <form method="POST" action="{{ route('procurement.downloadrequisitions') }}" id="tableForm">
        @csrf
        <div class="table-responsive">
          <table class="table table-striped table-bordered zero-configuration" style="width:100%">
            <thead class="table-light text-center">
              <tr>
                <th>#</th>
                <th>Requisition #</th>
                @php
                  $hiddenFields = ['invoiceamount','vendor','amount']; // case-insensitive handling below
                  $customLabels = [
                    'paymentmethod' => 'Payment Method',
                    'payment_method' => 'Payment Method',
                  ];
                @endphp

                @foreach($formFields as $field)
                  @continue(in_array(strtolower($field->name), $hiddenFields))
                  @php
                    $fieldName = strtolower($field->name);
                    $label = $customLabels[$fieldName] ?? ucfirst($field->name);
                  @endphp
                  <th>{{ $label }}</th>
                @endforeach

                <th>Next Approver</th>
                <th>Status</th>
                <th class="text-center actions">Action</th>
              </tr>
            </thead>

            <tbody>
              @foreach($frequisitions as $frequisition)
                @if(auth()->user()->id == $frequisition->userId || auth()->user()->userrole == $frequisition->approvedby)
                <tr>
                  <td class="text-center">
                    <input type="checkbox" id="select_{{ $frequisition->id }}" name="requisition_ids[]" value="{{ $frequisition->id }}">
                  </td>
                  <td>{{ $frequisition->requisitionNumber }}</td>

                  @php
                    $hiddenFields = ['invoiceamount','vendor','amount'];
                    $normalizedRequisition = [];
                    foreach ($frequisition->getAttributes() as $key => $value) {
                      $normalizedRequisition[strtolower(trim($key))] = $value;
                    }
                  @endphp

                  @foreach($formFields as $field)
                    @php $normalizedField = strtolower(trim($field->name)); @endphp
                    @continue(in_array($normalizedField, $hiddenFields))
                    <td>
                      @if ($normalizedField === 'department')
                        {{ $departments->firstWhere('id', $frequisition->department)->name ?? 'Unknown Department' }}
                      @else
                        {{ $normalizedRequisition[$normalizedField] ?? '' }}
                      @endif
                    </td>
                  @endforeach

                  {{-- Next Approver --}}
                  <td class="text-center">
                    @foreach($roles as $role)
                      @if($frequisition->approvedby == $role->id)
                        {{ $role->name }}
                      @endif
                    @endforeach
                  </td>

                  {{-- Status --}}
                  <td class="text-center">
                    @if($frequisition->status == 0 || $frequisition->status == 1)
                      <button type="button" class="btn btn-outline-primary btn-sm"><span class="fa fa-spinner"></span> Pending</button>
                    @elseif($frequisition->status == 2)
                      <button type="button" class="btn btn-outline-success btn-sm"><span class="fa fa-check-circle"></span> Approved</button>
                    @elseif($frequisition->status == 3)
                      <button type="button" class="btn btn-outline-danger btn-sm"><span class="fa fa-times-circle"></span> Rejected</button>
                    @elseif($frequisition->status == 4)
                      <button type="button" class="btn btn-outline-info btn-sm"><span class="fa fa-arrow-left"></span> Returned</button>
                    @else
                      <button type="button" class="btn btn-outline-primary btn-sm"><span class="fa fa-spinner"></span> Processing</button>
                    @endif
                  </td>

                  {{-- Actions (forced horizontal layout) --}}
                  <td class="text-center actions">
                    <div class="d-inline-flex flex-nowrap align-items-center gap-2">
                      @if($frequisition->userId == auth()->user()->id)
                        @if($frequisition->status == 4)
                          <a href="/procurement/{{ $frequisition->id }}/editrequisition" class="btn btn-info btn-sm text-white">
                            <span class="fa fa-desktop"></span> Update
                          </a>
                          <button type="button" class="btn btn-success btn-sm text-white"
                                  data-bs-toggle="modal" data-bs-target="#historyModal{{ $frequisition->id }}">
                            <span class="fa fa-pencil"></span> Logs
                          </button>
                          <a href="/procurement/{{ $frequisition->id }}/download" class="btn btn-primary btn-sm text-white">
                            <span class="fa fa-download"></span> Download
                          </a>
                        @else
                          <a href="/procurement/{{ $frequisition->id }}/viewrequisition" class="btn btn-info btn-sm text-white">
                            <span class="fa fa-desktop"></span> View
                          </a>
                          <button type="button" class="btn btn-success btn-sm text-white"
                                  data-bs-toggle="modal" data-bs-target="#historyModal{{ $frequisition->id }}">
                            <span class="fa fa-pencil"></span> Logs
                          </button>
                          <a href="/procurement/{{ $frequisition->id }}/download" class="btn btn-primary btn-sm text-white">
                            <span class="fa fa-download"></span> Download
                          </a>
                        @endif
                      @else
                        <a href="/procurement/{{ $frequisition->id }}/viewrequisition" class="btn btn-info btn-sm text-white">
                          <span class="fa fa-desktop"></span> View
                        </a>
                        <button type="button" class="btn btn-success btn-sm text-white"
                                data-bs-toggle="modal" data-bs-target="#historyModal{{ $frequisition->id }}">
                          <span class="fa fa-pencil"></span> Logs
                        </button>
                        <a href="/procurement/{{ $frequisition->id }}/download" class="btn btn-primary btn-sm text-white">
                          <span class="fa fa-download"></span> Download
                        </a>
                      @endif
                    </div>
                  </td>
                </tr>
                @endif
              @endforeach
            </tbody>
          </table>
        </div>
      </form>
    </div>
  </div>

  {{-- History Modals (Bootstrap 5) --}}
  @foreach($frequisitions as $frequisition)
    @if(auth()->user()->id == $frequisition->userId || auth()->user()->userrole == $frequisition->approvedby)
    <div class="modal fade" id="historyModal{{ $frequisition->id }}" tabindex="-1" aria-labelledby="historyModalLabel{{ $frequisition->id }}" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="historyModalLabel{{ $frequisition->id }}">Requisition Logs - {{ $frequisition->requisitionNumber }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <section class="bsb-timeline-7 py-3">
              <div class="container">
                <div class="row justify-content-center">
                  <div class="col-12">
                    @if($frequisition->histories->isEmpty())
                      <p>No history found for this requisition.</p>
                    @else
                      <ul class="timeline">
                        @foreach($frequisition->histories as $history)
                          @php $date = \Carbon\Carbon::parse($history->created_at); @endphp
                          <li class="timeline-item">
                            <div class="timeline-body">
                              <div class="timeline-meta">
                                <div class="d-inline-flex flex-column px-2 py-1 text-success-emphasis bg-success-subtle border rounded-2">
                                  <span class="fw-bold">{{ $date->format('d F Y') }}</span>
                                  <span>{{ $date->format('g:ia') }}</span>
                                </div>
                              </div>
                              <div class="timeline-content timeline-indicator">
                                <div class="card border-0 shadow">
                                  <div class="card-body p-xl-4" style="position:relative;">
                                    <h6 class="card-subtitle text-secondary mb-3" style="position:absolute; top:10px; right:10px;">{{ $loop->iteration }}</h6>
                                    <h2 class="card-title mb-2">{{ $history->doneby }}</h2>
                                    <p class="card-text m-0">{{ $history->action }}</p>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </li>
                        @endforeach
                      </ul>
                    @endif
                  </div>
                </div>
              </div>
            </section>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    @endif
  @endforeach

  {{-- Filter Modal (Bootstrap 5) --}}
  <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
      <form method="GET" action="{{ route('requisition.filtered') }}" enctype="multipart/form-data">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="filterModalLabel">Filter Purchase Order Summary</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <div class="modal-body">
            <div class="mb-3">
              <label for="start_date" class="form-label">Date From</label>
              <input class="form-control" id="start_date" name="start_date" type="date">
            </div>

            <div class="mb-3">
              <label for="end_date" class="form-label">Date To</label>
              <input class="form-control" id="end_date" name="end_date" type="date">
            </div>

            <div class="mb-3">
              <label for="status" class="form-label">Status</label>
              <select name="status" id="status" class="form-control">
                <option value="">--Select Status--</option>
                <option value="2">Approved</option>
                <option value="3">Rejected</option>
                <option value="1">Pending</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="vendor" class="form-label">Vendor</label>
              <select name="vendor" id="vendor" class="form-control">
                <option value="">--Select Vendor--</option>
                @if(isset($vendors))
                  @foreach($vendors as $vendor)
                    <option value="{{ $vendor->vendor }}">{{ $vendor->vendor }}</option>
                  @endforeach
                @endif
              </select>
            </div>
          </div>

          <div class="modal-footer">
            <button class="btn btn-danger" type="button" data-bs-dismiss="modal" style="padding:10px 20px; min-width:110px;">Close</button>
            <button class="btn btn-success" type="submit" style="padding:10px 20px; min-width:150px;">Filter Summary</button>
          </div>
        </div>
      </form>
    </div>
  </div>

</div>
@endsection

{{-- Scripts --}}
<script src="https://unpkg.com/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  // Header Download: ensure at least one checkbox selected and copy selections into header form
  const headerForm = document.getElementById('headerDownloadForm');
  const hiddenContainer = document.getElementById('downloadHiddenInputs');

  headerForm.addEventListener('submit', function (e) {
    // Clear previous hidden inputs
    hiddenContainer.innerHTML = '';

    const checked = document.querySelectorAll('input[name="requisition_ids[]"]:checked');
    if (checked.length === 0) {
      e.preventDefault();
      Swal.fire({
        icon: 'warning',
        title: 'No Selection',
        text: 'Please select at least one checkbox before downloading.',
        confirmButtonText: 'Okay'
      });
      return false;
    }

    // Copy selected ids into this form so the server receives them
    checked.forEach(cb => {
      const inp = document.createElement('input');
      inp.type = 'hidden';
      inp.name = 'requisition_ids[]';
      inp.value = cb.value;
      hiddenContainer.appendChild(inp);
    });
  });

  // If someone submits the table form directly (e.g., via keyboard), also protect it
  const tableForm = document.getElementById('tableForm');
  if (tableForm) {
    tableForm.addEventListener('submit', function (e) {
      const checked = document.querySelectorAll('input[name="requisition_ids[]"]:checked');
      if (checked.length === 0) {
        e.preventDefault();
        Swal.fire({
          icon: 'warning',
          title: 'No Selection',
          text: 'Please select at least one checkbox before downloading.',
          confirmButtonText: 'Okay'
        });
      }
    });
  }
});
</script>
