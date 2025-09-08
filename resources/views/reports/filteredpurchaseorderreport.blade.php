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

          <!-- Card Header with flex layout -->
      <div class="card-header d-flex justify-content-between align-items-center">
          <strong>Purchase Orders</strong>
          <div class="d-flex gap-2">

              <!-- Download button inside form -->
              {{-- <form method="POST" action="{{ route('procurement.downloadrequisitions') }}">
                  @csrf
                  <button type="submit" class="btn btn-success btn-sm">
                      <i class="fa fa-download"></i> Download
                  </button>
              </form> --}}

          </div>
      </div>
          <div class="card-body">
            <form method="POST" action="{{ route('procurement.downloadrequisitions') }}">
              @csrf
              <table class="table table-striped table-bordered zero-configuration">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Requisition #</th>   
                    @php
                        $hiddenFields = []; // No hidden fields now
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
                <tbody>
                  @foreach($fpurchaseorders as $fpurchaseorder)
                  <tr>
                    @if(auth()->user()->id == $fpurchaseorder->userId OR auth()->user()->userrole  == $fpurchaseorder->approvedby )
                    <td><input type="checkbox" id="select" name="requisition_ids[]" value="{{ $fpurchaseorder->id }}"></td>
                    <td>{{ $fpurchaseorder->requisitionNumber }}</td>

                    @php
                      $hiddenFields = [''];
                      $normalizedRequisition = [];
                      foreach ($fpurchaseorder->getAttributes() as $key => $value) {
                          $normalizedRequisition[strtolower(trim($key))] = $value;
                      }
                    @endphp

                    @foreach($formFields as $field)
                      @php
                          $normalizedField = strtolower(trim($field->name));
                      @endphp

                      @continue(in_array($normalizedField, $hiddenFields))

                      <td>
                          @if ($normalizedField === 'department')
                              {{ $departments->firstWhere('id', $fpurchaseorder->department)->name ?? 'Unknown Department' }}
                          @else
                              {{ $normalizedRequisition[$normalizedField] ?? '' }}
                          @endif
                      </td>
                    @endforeach   

                    <td class="text-center">
                      @foreach($roles as $role)
                        @if($fpurchaseorder->approvedby == $role->id)
                          {{$role->name}}
                        @endif
                      @endforeach
                    </td>

                    <td class="text-center">
                      @if($fpurchaseorder->status == 0)
                        <button type="button" class="btn btn-outline-primary"><span class="fa fa-spinner"></span> Pending</button>
                      @elseif($fpurchaseorder->status == 1)
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
            
                    <td class="text-center">

                      @if($fpurchaseorder->status == 0 OR $fpurchaseorder->status == 4)
                        @if($fpurchaseorder->userId == auth()->user()->id)
                          <a href='/procurement/{{$fpurchaseorder->id}}/purchaseorder' class='btn btn-secondary btn-sm text-white'>
                            <span class='fa fa-pencil'></span> Upload
                          </a>&nbsp; 
                        @endif 
                        <a href="#" class='btn btn-success btn-sm text-white' data-toggle="modal" data-target="#historyModal{{ $fpurchaseorder->id }}">
                          <span class='fa fa-list'></span> Logs
                        </a>&nbsp;

                        <!-- History Modal -->
                        <div class="modal fade" id="historyModal{{ $fpurchaseorder->id }}" tabindex="-1" role="dialog" aria-labelledby="historyModalLabel{{ $fpurchaseorder->id }}" aria-hidden="true">
                          <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title">Requisition Logs</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <section class="bsb-timeline-7 py-3">
                                  <div class="container">
                                    <div class="row justify-content-center">
                                      <div class="col-12">
                                        @if($fpurchaseorder->histories->isEmpty())
                                          <p>No history found for this requisition.</p>
                                        @else
                                          <ul class="timeline">
                                            @foreach($fpurchaseorder->histories as $history)
                                              @php
                                                $date = \Carbon\Carbon::parse($history->created_at);
                                              @endphp
                                              <li class="timeline-item">
                                                <div class="timeline-body">
                                                  <div class="timeline-meta">
                                                    <div class="d-inline-flex flex-column px-2 py-1 text-success-emphasis bg-success-subtle border border-success-subtle rounded-2 text-md-end">
                                                      <span class="fw-bold">{{$date->format('d F Y')}}</span>
                                                      <span>{{$date->format('g:ia')}}</span>
                                                    </div>
                                                  </div>
                                                  <div class="timeline-content timeline-indicator">
                                                    <div class="card border-0 shadow">
                                                      <div class="card-body p-xl-4" style="position: relative;">
                                                        <h6 class="card-subtitle text-secondary mb-3" style="position: absolute; top: 10; right: 10;">{{ $loop->iteration }}</h6>
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

                      @else
                        <a href='/procurement/{{$fpurchaseorder->id}}/viewpurchaseorder' class='btn btn-info btn-sm text-white'>
                          <span class=''></span> View
                        </a>&nbsp;
                        <a href="#" class='btn btn-success btn-sm text-white' data-toggle="modal" data-target="#historyModal{{ $fpurchaseorder->id }}">
                          <span class='fa fa-list'></span> Logs
                        </a>&nbsp;

                        <!-- History Modal -->
                        <div class="modal fade" id="historyModal{{ $fpurchaseorder->id }}" tabindex="-1" role="dialog" aria-labelledby="historyModalLabel{{ $fpurchaseorder->id }}" aria-hidden="true">
                          <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title">Requisition Logs</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <section class="bsb-timeline-7 py-3">
                                  <div class="container">
                                    <div class="row justify-content-center">
                                      <div class="col-12">
                                        @if($fpurchaseorder->histories->isEmpty())
                                          <p>No history found for this requisition.</p>
                                        @else
                                          <ul class="timeline">
                                            @foreach($fpurchaseorder->histories as $history)
                                              @php
                                                $date = \Carbon\Carbon::parse($history->created_at);
                                              @endphp
                                              <li class="timeline-item">
                                                <div class="timeline-body">
                                                  <div class="timeline-meta">
                                                    <div class="d-inline-flex flex-column px-2 py-1 text-success-emphasis bg-success-subtle border border-success-subtle rounded-2 text-md-end">
                                                      <span class="fw-bold">{{$date->format('d F Y')}}</span>
                                                      <span>{{$date->format('g:ia')}}</span>
                                                    </div>
                                                  </div>
                                                  <div class="timeline-content timeline-indicator">
                                                    <div class="card border-0 shadow">
                                                      <div class="card-body p-xl-4" style="position: relative;">
                                                        <h6 class="card-subtitle text-secondary mb-3" style="position: absolute; top: 10; right: 10;">{{ $loop->iteration }}</h6>
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

                      @endif
                  
                    </td>
                  </tr>
                  @endif
                  @endforeach
                </tbody>
              </table>        
            </form>
          </div>

        </div>
      </div>
    </div>


    <!-- Filter Modal -->
    <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-primary modal-md" role="document">
        <form method="post" action="{{ route('purchaseorder.filtered') }}" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Filter Purchase Order Summary</h4>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label>Date From</label>
                <input class="form-control" name="start_date" type="date">
              </div>
              <div class="form-group">
                <label>Date To</label>
                <input class="form-control" name="end_date" type="date" >
              </div>
              <div class="form-group">
                <label>Status</label>
                <select name="status" id="status" class="form-control">     
                  <option value="">--Select Status--</option>       
                  <option value="2">Approved</option>       
                  <option value="3">Rejected</option>  
                  <option value="1">Pending</option>     
                </select>
              </div>
              <div class="form-group">
                <label>Vendor</label>
                <select name="vendor" id="vendor" class="form-control">   
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
</div>
@endsection

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const downloadButton = document.querySelector('form button[type="submit"]');
    const form = document.querySelector('form');

    downloadButton.addEventListener('click', function(event) {
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
