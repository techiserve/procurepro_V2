@extends('html.default')

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
  </ul>
</div>

<div class="body-content__wrapper requesition-body">
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <strong>Requisitions</strong>

      <div class="d-flex align-items-center">
        <!-- FILTER BUTTON (BS4 modal trigger) -->
        <button class="btn btn-primary btn-sm mr-2" data-toggle="modal" data-target="#filterModal"
                style="padding: 10px 20px; font-size: 16px; min-width: 100px;">
          <i class="fa fa-filter"></i> Filter
        </button>

        <!-- DOWNLOAD BUTTON submits #tableForm (the form that contains the checkboxes) -->
        <button type="submit" form="tableForm" class="btn btn-success btn-sm"
                style="padding: 10px 20px; font-size: 16px; min-width: 100px;">
          <i class="fa fa-download"></i> Download
        </button>
      </div>
    </div>

    <div class="card-body">
      {{-- SINGLE form holding the checkboxes + posts to download route --}}
      <form method="POST" action="{{ route('procurement.downloadrequisitions') }}" id="tableForm">
        @csrf
        <div class="table-responsive">
          <table class="table table-striped table-bordered zero-configuration" id="example" style="width:100%">
            <thead class="table-light text-center">
              <tr>
                <th>#</th>
                <th>Requisition #</th>
                @php
                  $hiddenFields = ['invoiceamount']; // Add more fields to hide as needed
                  $customLabels = [
                    'paymentmethod'  => 'Payment Method',
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
                <th>Date</th>
                <th>Next Approver</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>

            <tbody>
              @foreach($frequisitions as $frequisition)
                <tr>
                  <td>
                    <input type="checkbox"
                           id="select_{{ $frequisition->id }}"
                           name="requisition_ids[]"
                           value="{{ $frequisition->id }}">
                  </td>

                  <td>{{ $frequisition->requisitionNumber }}</td>

                  @php
                    $hiddenFields = ['invoiceamount'];
                    // Normalize requisition data to lowercase keys for safe access
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
                  <td class="text-center"> 
                      {{ \Carbon\Carbon::parse($frequisition->created_at)->format('d M Y') }}
                  </td>
                  <td class="text-center">
                    @foreach($roles as $role)
                      @if($frequisition->approvedby == $role->id)
                        {{ $role->name }}
                      @endif
                    @endforeach
                  </td>

                  <td class="text-center">
            @if($frequisition->status == 0 || $frequisition->status == 1) <button type="button" class="btn btn-outline-primary"> <span class="fa fa-spinner"></span> Pending </button> @elseif($frequisition->status == 2) <button type="button" class="btn btn-outline-success"> <span class="fa fa-check-circle"></span> Approved </button> @elseif($frequisition->status == 3) <button type="button" class="btn btn-outline-danger"> <span class="fa fa-times-circle"></span> Rejected </button> @elseif($frequisition->status == 4) <button type="button" class="btn btn-outline-info"> <span class="fa fa-arrow-left"></span> Returned </button> @elseif($frequisition->status == 6) <button type="button" class="btn btn-outline-danger"> <span class="fa fa-arrow-left"></span> Voided </button> @else <button type="button" class="btn btn-outline-primary"> <span class="fa fa-spinner"></span> Processing </button> @endif
                  </td>

                  <td class="text-center actions">
                    @if($frequisition->userId == auth()->user()->id)
                      @if($frequisition->status == 4)
                        <a href="/procurement/{{$frequisition->id}}/editrequisition" class="btn btn-info btn-sm text-white">
                          <span class="fa fa-desktop"></span> Update
                        </a>&nbsp;
                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#historyModal{{ $frequisition->id }}">
                          <span class="fa fa-pencil"></span> Logs
                        </button>&nbsp;
                        <a href="/procurement/{{$frequisition->id}}/download" class="btn btn-primary btn-sm text-white">
                          <span class="fa fa-download"></span> Download
                        </a>&nbsp;
                        @if(empty($frequisition->pop))
                       <button type="button" class="btn btn-info btn-sm"
                            data-bs-toggle="modal" data-bs-target="#pop{{ $frequisition->id }}">
                       <span class="fa fa-upload"></span> Upload POP
                       @endif
                    </button>

                      @else
                        <a href="/procurement/{{$frequisition->id}}/viewrequisition" class="btn btn-info btn-sm text-white">
                          <span class="fa fa-desktop"></span> View
                        </a>&nbsp;
                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#historyModal{{ $frequisition->id }}">
                          <span class="fa fa-pencil"></span> Logs
                        </button>&nbsp;
                        <a href="/procurement/{{$frequisition->id}}/download" class="btn btn-primary btn-sm text-white">
                          <span class="fa fa-download"></span> Download
                        </a>&nbsp;
                         @if(empty($frequisition->pop))
                       <button type="button" class="btn btn-info btn-sm"
                            data-bs-toggle="modal" data-bs-target="#pop{{ $frequisition->id }}">
                      <span class="fa fa-upload"></span> Upload POP
                      @endif
                    </button>

                      @endif
                    @else
                      <a href="/procurement/{{$frequisition->id}}/viewrequisition" class="btn btn-info btn-sm text-white">
                        <span class="fa fa-desktop"></span> View
                      </a>&nbsp;
                      <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#historyModal{{ $frequisition->id }}">
                        <span class="fa fa-pencil"></span> Logs
                      </button>&nbsp;
                      <a href="/procurement/{{$frequisition->id}}/download" class="btn btn-primary btn-sm text-white">
                        <span class="fa fa-download"></span> Download
                      </a>&nbsp;
                       @if(empty($frequisition->pop))
                       <button type="button" class="btn btn-info btn-sm"
                       data-bs-toggle="modal" data-bs-target="#pop{{ $frequisition->id }}">
                      <span class="fa fa-upload"></span> Upload POP
                      @endif
                    </button>

                    @endif
                  </td>
                </tr>

                <div class="modal fade" id="pop{{ $frequisition->id }}" tabindex="-1" aria-labelledby="pop{{ $frequisition->id }}Label" aria-hidden="true">
                  <div class="modal-dialog modal-md">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title" id="pop{{ $frequisition->id }}Label">
                          <i class="fa fa-envelope"></i> Upload Proof of Payment
                        </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <form method="POST" action="/procurement/{{ $frequisition->id }}/reqPop" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="modal-body" style="font-size:14px;">
                          <div class="mb-3">
                            <label for="popfile{{ $frequisition->id }}" class="form-label">Upload document</label>
                            <input type="file" name="pop" id="popfile{{ $frequisition->id }}" class="form-control" required />
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary">
                            <span class="fa fa-upload"></span> Upload
                          </button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

              @endforeach
            </tbody>
          </table>
        </div>
      </form>
      {{-- END #tableForm --}}
    </div>
  </div>






  {{-- History Modals (outside the table form) --}}
  @foreach($frequisitions as $frequisition)
    <div class="modal fade" id="historyModal{{ $frequisition->id }}" tabindex="-1" role="dialog" aria-labelledby="historyModalLabel{{ $frequisition->id }}" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="historyModalLabel{{ $frequisition->id }}">Requisition Logs - {{ $frequisition->requisitionNumber }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
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
                                <div class="d-inline-flex flex-column px-2 py-1 text-success-emphasis bg-success-subtle border border-success-subtle rounded-2 text-md-end">
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
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  @endforeach

  <!-- Filter Modal (Bootstrap 4 attributes) -->
  <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <form method="GET" action="{{ route('requisition.filtered') }}" enctype="multipart/form-data">
      
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="filterModalLabel">Filter Requisitions</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <div class="form-col">
              <label for="start_date">Date From</label>
              <input class="form-control" id="start_date" name="start_date" type="date">
            </div>

            <div class="form-col mt-3">
              <label for="end_date">Date To</label>
              <input class="form-control" id="end_date" name="end_date" type="date">
            </div>

            <div class="form-col mt-3">
              <label for="status">Status</label>
              <select name="status" id="status" class="form-control" style="width:100%;">
                <option value="">--Select Status--</option>
                <option value="2">Approved</option>
                <option value="3">Rejected</option>
                <option value="1">Pending</option>
              </select>
            </div>

            <div class="form-col mt-3">
              <label for="vendor">Vendor</label>
              <select name="vendor" id="vendor" class="form-control" style="width:100%;">
                <option value="">--Select Vendor--</option>
                @foreach($vendors as $vendor)
                  <option value="{{ $vendor->vendor }}">{{ $vendor->vendor }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="modal-footer">
            <button class="btn btn-danger" type="button" data-dismiss="modal" style="padding:10px 20px; font-size:16px; min-width:100px;">Close</button>
            <button class="btn btn-success" type="submit" style="padding:10px 20px; font-size:16px; min-width:140px;">Filter Summary</button>
          </div>
        </div>
      </form>
    </div>
  </div>

</div>
@endsection

<!-- Include jQuery and Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.min.js"></script>

<script>
  // Validate ONLY the table form (not the filter modal form)
  $(function () {
    $('#tableForm').on('submit', function (e) {
      var checked = $(this).find('input[name="requisition_ids[]"]:checked').length;
      if (!checked) {
        e.preventDefault();
        Swal.fire({
          icon: 'warning',
          title: 'No Selection',
          text: 'Please select at least one requisition before downloading.',
          confirmButtonText: 'Okay'
        });
      }
    });
  });
</script>
