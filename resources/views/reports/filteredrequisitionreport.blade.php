@extends('html.default')
<link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/tutorials/timelines/timeline-7/assets/css/timeline-7.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@section('content')
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">

          {{-- Header with title on the left and actions on the right --}}
          <div class="card-header d-flex align-items-center">
            <strong>Requisitions</strong>

            <div class="ms-auto d-flex gap-2">
              {{-- Download submits the table form below --}}
              <button id="downloadBtn"
                      type="submit"
                      class="btn btn-success btn-sm"
                      form="requisitionTableForm"
                      style="padding:10px 20px; font-size:16px; min-width:100px;">
                <i class="fa fa-download"></i> Download
              </button>

              {{-- Filter opens the modal (support both BS4/BS5 data attrs) --}}
              <button class="btn btn-primary btn-sm"
                      style="padding:10px 20px; font-size:16px; min-width:100px;"
                      data-toggle="modal" data-target="#filterModal"
                      data-bs-toggle="modal" data-bs-target="#filterModal">
                <i class="fa fa-filter"></i> Filter
              </button>
            </div>
          </div>

          <div class="card-body">
            {{-- SINGLE form that holds the checkboxes --}}
            <form id="requisitionTableForm" method="POST" action="{{ route('procurement.downloadrequisitions') }}">
              @csrf

              <div class="table-responsive">
                <table class="table table-striped table-bordered zero-configuration">
                  <thead class="table-light">
                    <tr>
                      <th>#</th>
                      <th>Requisition #</th>
                      @php
                        $hiddenFields = ['invoiceamount']; // Add more fields to hide as needed
                        $customLabels = [
                          'paymentmethod'  => 'Payment Method',
                          'payment_method' => 'Payment Method',
                          // Add more custom mappings here
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
                      <th class="text-center">Action</th>
                    </tr>
                  </thead>

                  <tbody>
                    @foreach($frequisitions as $frequisition)
                      @if(auth()->user()->id == $frequisition->userId || auth()->user()->userrole == $frequisition->approvedby)
                        <tr>
                          <td>
                            {{-- unique id per checkbox --}}
                            <input type="checkbox"
                                   id="select_{{ $frequisition->id }}"
                                   name="requisition_ids[]"
                                   value="{{ $frequisition->id }}">
                          </td>

                          <td>{{ $frequisition->requisitionNumber }}</td>

                          @php
                            $hiddenFields = ['invoiceamount'];
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
                            @foreach($roles as $role)
                              @if($frequisition->approvedby == $role->id)
                                {{ $role->name }}
                              @endif
                            @endforeach
                          </td>

                          <td class="text-center">
                            @if($frequisition->status == 0 || $frequisition->status == 1)
                              <button type="button" class="btn btn-outline-primary">
                                <span class="fa fa-spinner"></span> Pending
                              </button>
                            @elseif($frequisition->status == 2)
                              <button type="button" class="btn btn-outline-success">
                                <span class="fa fa-check-circle"></span> Approved
                              </button>
                            @elseif($frequisition->status == 3)
                              <button type="button" class="btn btn-outline-danger">
                                <span class="fa fa-times-circle"></span> Rejected
                              </button>
                            @elseif($frequisition->status == 4)
                              <button type="button" class="btn btn-outline-info">
                                <span class="fa fa-arrow-left"></span> Returned
                              </button>
                            @else
                              <button type="button" class="btn btn-outline-primary">
                                <span class="fa fa-spinner"></span> Processing
                              </button>
                            @endif
                          </td>

                          <td class="text-center">
                            @if($frequisition->userId == auth()->user()->id)
                              @if($frequisition->status == 4)
                                <a href="/procurement/{{$frequisition->id}}/editrequisition" class="btn btn-info btn-sm text-white">
                                  <span class="fa fa-desktop"></span> Update
                                </a>&nbsp;
                                <a href="#" class="btn btn-success btn-sm"
                                   data-toggle="modal" data-target="#historyModal{{ $frequisition->id }}"
                                   style="color:white;">
                                  <span class="fa fa-pencil"></span> Logs
                                </a>&nbsp;
                                <a href="/procurement/{{$frequisition->id}}/download" class="btn btn-primary btn-sm text-white">
                                  <span class="fa fa-download"></span> Download
                                </a>&nbsp;
                              @else
                                <a href="/procurement/{{$frequisition->id}}/viewrequisition" class="btn btn-info btn-sm text-white">
                                  <span class="fa fa-desktop"></span> View
                                </a>&nbsp;
                                <a href="#" class="btn btn-success btn-sm"
                                   data-toggle="modal" data-target="#historyModal{{ $frequisition->id }}"
                                   style="color:white;">
                                  <span class="fa fa-pencil"></span> Logs
                                </a>&nbsp;
                                <a href="/procurement/{{$frequisition->id}}/download" class="btn btn-primary btn-sm text-white">
                                  <span class="fa fa-download"></span> Download
                                </a>&nbsp;
                              @endif
                            @else
                              <a href="/procurement/{{$frequisition->id}}/viewrequisition" class="btn btn-info btn-sm text-white">
                                <span class="fa fa-desktop"></span> View
                              </a>&nbsp;
                              <a href="#" class="btn btn-success btn-sm"
                                 data-toggle="modal" data-target="#historyModal{{ $frequisition->id }}"
                                 style="color:white;">
                                <span class="fa fa-pencil"></span> Logs
                              </a>&nbsp;
                              <a href="/procurement/{{$frequisition->id}}/download" class="btn btn-primary btn-sm text-white">
                                <span class="fa fa-download"></span> Download
                              </a>&nbsp;
                            @endif
                          </td>
                        </tr>
                      @endif
                    @endforeach
                  </tbody>
                </table>
              </div>
            </form>
            {{-- END #requisitionTableForm --}}
          </div>

        </div>
      </div>
    </div>
  </div>

  {{-- Filter Modal --}}
  <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-primary modal-md" role="document">
      <form method="post" action="{{ route('requisition.filtered') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Filter Requisitions</h4>
       
          </div>

          <div class="modal-body">
            <div class="form-group">
              <label>Date From</label>
              <input class="form-control" name="start_date" type="date">
            </div>

            <div class="form-group">
              <label>Date To</label>
              <input class="form-control" name="end_date" type="date">
            </div>

            <div class="form-group">
              <label>Status</label>
              <select name="status" id="status" class="js-example-basic-single form-control" style="width:100%;">
                <option value="">--Select Status--</option>
                <option value="2">Approved</option>
                <option value="3">Rejected</option>
                <option value="1">Pending</option>
              </select>
            </div>

            <div class="form-group">
              <label>Vendor</label>
              <select name="vendor" id="vendor" class="js-example-basic-single form-control" style="width:100%;">
                <option value="">--Select Vendor--</option>
                @foreach($vendors as $vendor)
                  <option value="{{ $vendor->vendor }}">{{ $vendor->vendor }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
            <button class="btn btn-primary" type="submit">Filter Summary</button>
          </div>
        </div>
      </form>
    </div>
  </div>

</div>
@endsection

<script>
  // Validate ONLY the table form (not the filter modal form)
  document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('requisitionTableForm');
    if (!form) return;

    form.addEventListener('submit', function (e) {
      const checked = form.querySelectorAll('input[name="requisition_ids[]"]:checked').length;
      if (!checked) {
        e.preventDefault();
        Swal.fire({
          icon: 'warning',
          title: 'No Selection',
          text: 'Please select at least one checkbox before downloading.',
          confirmButtonText: 'Okay'
        });
      }
    });
  });
</script>
