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
          <div class="card-header d-flex justify-content-between align-items-center">
            <strong>Purchase Orders</strong>

            <div>
              <form method="POST" action="{{ route('procurement.downloadpurchaseorder') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-success btn-sm me-2" id="downloadBtn">
                  <i class="fa fa-download"></i> Download
                </button>
              </form>

              <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#filterModal">
                <i class="fa fa-filter"></i> Filter
              </button>
            </div>
          </div>

          <div class="card-body">
            <div style="overflow-x:auto;">
              <table class="table table-striped table-bordered zero-configuration">
                {{-- Table Head --}}
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Requisition #</th>
                    @php
                      $hiddenFields = [];
                      $customLabels = [
                          'paymentmethod' => 'Payment Method',
                          'payment_method' => 'Payment Method',
                          'invoiceamount' => 'Invoice Amount',
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

                {{-- Table Body --}}
                <tbody>
                  @foreach($fpurchaseorders as $fpurchaseorder)
                  <tr>
                    <td>
                      <input type="checkbox" name="requisition_ids[]" value="{{ $fpurchaseorder->id }}">
                    </td>
                    <td>{{ $fpurchaseorder->requisitionNumber }}</td>

                    @php
                      $normalizedRequisition = [];
                      foreach ($fpurchaseorder->getAttributes() as $key => $value) {
                          $normalizedRequisition[strtolower(trim($key))] = $value;
                      }
                    @endphp

                    @foreach($formFields as $field)
                      @php $normalizedField = strtolower(trim($field->name)); @endphp
                      @continue(in_array($normalizedField, $hiddenFields))
                      <td>
                        @if ($normalizedField === 'department')
                          {{ $departments->firstWhere('id', $fpurchaseorder->department)->name ?? 'Unknown Department' }}
                        @else
                          {{ $normalizedRequisition[$normalizedField] ?? '' }}
                        @endif
                      </td>
                    @endforeach

                    {{-- Next Approver --}}
                    <td class="text-center">
                      @foreach($roles as $role)
                        @if($fpurchaseorder->approvedby == $role->id)
                          {{$role->name}}
                        @endif
                      @endforeach
                    </td>

                    {{-- Status --}}
                    <td class="text-center">
                      @if($fpurchaseorder->status == 0 || $fpurchaseorder->status == 1)
                        <button type="button" class="btn btn-outline-primary"><span class="fa fa-spinner"></span> Pending</button>
                      @elseif($fpurchaseorder->status == 2)
                        <button type="button" class="btn btn-outline-success"><span class="fa fa-check-circle"></span> Approved</button>
                      @elseif($fpurchaseorder->status == 3)
                        <button type="button" class="btn btn-outline-danger"><span class="fa fa-times-circle"></span> Rejected</button>
                      @elseif($fpurchaseorder->status == 4)
                        <button type="button" class="btn btn-outline-info"><span class="fa fa-arrow-left"></span> Returned</button>
                      @else
                        <button type="button" class="btn btn-outline-primary"><span class="fa fa-spinner"></span> Processing</button>
                      @endif
                    </td>

                    {{-- Actions --}}
                    <td class="text-center">
                      @if($fpurchaseorder->status == 0 || $fpurchaseorder->status == 4)
                        @if($fpurchaseorder->userId == auth()->user()->id)
                          <a href='/procurement/{{$fpurchaseorder->id}}/purchaseorder' class='btn btn-secondary btn-sm'>
                            <span class='fa fa-upload'></span> Upload
                          </a>
                        @endif 
                      @else
                        <a href='/procurement/{{$fpurchaseorder->id}}/viewpurchaseorder' class='btn btn-info btn-sm'>
                          <span class='fa fa-eye'></span> View
                        </a>
                      @endif

                      {{-- Logs Button --}}
                      <button class='btn btn-success btn-sm' data-bs-toggle="modal" data-bs-target="#historyModal{{ $fpurchaseorder->id }}">
                        <span class='fa fa-history'></span> Logs
                      </button>

                      {{-- History Modal --}}
                      <div class="modal fade" id="historyModal{{ $fpurchaseorder->id }}" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Requisition Logs</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                              <section class="bsb-timeline-7 py-3">
                                <div class="container">
                                  @if($fpurchaseorder->histories->isEmpty())
                                    <p>No history found for this requisition.</p>
                                  @else
                                    <ul class="timeline">
                                      @foreach($fpurchaseorder->histories as $history)
                                        @php $date = \Carbon\Carbon::parse($history->created_at); @endphp
                                        <li class="timeline-item">
                                          <div class="timeline-body">
                                            <div class="timeline-meta">
                                              <div class="d-inline-flex flex-column px-2 py-1 text-success-emphasis bg-success-subtle border rounded-2">
                                                <span class="fw-bold">{{$date->format('d F Y')}}</span>
                                                <span>{{$date->format('g:ia')}}</span>
                                              </div>
                                            </div>
                                            <div class="timeline-content timeline-indicator">
                                              <div class="card border-0 shadow">
                                                <div class="card-body p-xl-4">
                                                  <h6 class="card-subtitle text-secondary mb-3">{{ $loop->iteration }}</h6>
                                                  <h2 class="card-title mb-2">{{$history->doneby}}</h2>
                                                  <p class="card-text m-0">{{$history->action}}</p>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </li>
                                      @endforeach
                                    </ul>
                                  @endif
                                </div>
                              </section>
                            </div>
                          </div>
                        </div>
                      </div>

                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table> 
            </div>
          </div>

        </div>
      </div>
    </div>

    {{-- Filter Modal --}}


  </div>
</div>

@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
  document.getElementById('downloadBtn').addEventListener('click', function(event) {
    const checkboxes = document.querySelectorAll('input[name="requisition_ids[]"]:checked');
    if (checkboxes.length === 0) {
      event.preventDefault();
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
