@extends('html.default')

<link rel="stylesheet" href="https://unpkg.com/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/tutorials/timelines/timeline-7/assets/css/timeline-7.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@section('content')
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
          
              <strong>Requisitions</strong>
           
          </div>
    
          <div class="card-body">
            <!-- Action buttons aligned to the right above the table -->
            <div class="row mb-3">
              <div class="col-12">
                <div class="float-right">
                  <button class="btn btn-primary btn-sm mr-2" data-toggle="modal" data-target="#filterModal" style="padding: 10px 20px; font-size: 16px; min-width: 100px;">
                    <i class="fa fa-filter"></i> Filter
                  </button>
                  <form method="POST" action="{{ route('procurement.downloadrequisitions') }}" style="display: inline-block;">
                    @csrf
                    <button type="submit" class="btn btn-success btn-sm" style="padding: 10px 20px; font-size: 16px; min-width: 100px;">
                      <i class="fa fa-download"></i> Download
                    </button>
                  </form>
                </div>
              </div>
            </div>

            <!-- Checkbox form for table data -->
            <form method="POST" action="{{ route('procurement.downloadrequisitions') }}" id="tableForm">
              @csrf
              <div style="overflow-x:auto;">
                <table class="table table-striped table-bordered zero-configuration">
                  <thead>
                    <tr>
                    <th>#</th>
                    <th>Requisition #</th>   
                      @php
                            $hiddenFields = ['invoiceamount','Vendor','vendor','amount','Amount']; // Add more fields to hide as needed
                            $customLabels = [
                                'paymentmethod' => 'Payment Method',
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
                <input type="checkbox" id="select_{{ $frequisition->id }}" name="requisition_ids[]" value="{{ $frequisition->id }}">
            </td>
            <td>{{ $frequisition->requisitionNumber }}</td>

            @php
                $hiddenFields = ['invoiceamount','Vendor','vendor','amount','Amount'];
                // Normalize requisition data to lowercase keys for safe access
                $normalizedRequisition = [];
                foreach ($frequisition->getAttributes() as $key => $value) {
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
                        {{-- Map department ID to department name --}}
                        {{ $departments->firstWhere('id', $frequisition->department)->name ?? 'Unknown Department' }}
                    @else
                        {{ $normalizedRequisition[$normalizedField] ?? '' }}
                    @endif
                </td>
            @endforeach          
                   <!-- <td>{{ $frequisition->userId }}</td>
                        <td>{{ $frequisition->companyId }}</td>
                        <td>{{ $frequisition->status }}</td>
                        <td>{{ $frequisition->isActive }}</td>
                        <td>{{ $frequisition->approvallevel }}</td>
                        <td>{{ $frequisition->totalapprovallevels }}</td>
                        <td>{{ $frequisition->approvedby }}</td> -->
                      <td class="text-center">

                      @foreach($roles as $role)
                      @if($frequisition->approvedby == $role->id)
                      {{$role->name}}
                      @endif
                      @endforeach
                 
                      </td>

                      <td class="text-center">
                  
                  @if($frequisition->status == 0)
                  <button type="button" class="btn btn-outline-primary"><span class="fa fa-spinner"></span> Pending</button>
                    @elseif($frequisition->status == 1)
                    <button type="button" class="btn btn-outline-primary"><span class="fa fa-spinner"></span> Pending</button>
                    @elseif($frequisition->status == 2)
                    <button type="button" class="btn btn-outline-success"><span class="fa fa-check-circle"></span> Approved</button>
                    @elseif($frequisition->status == 3)
                    <button type="button" class="btn btn-outline-danger"><span class="fa fa-times-circle"></span> Rejected</button>
                    @elseif($frequisition->status == 4)
                    <button type="button" class="btn btn-outline-info"><span class="fa fa-arrow-left"></span> Returned</button>
                    @else
                    <button type="button" class="btn btn-outline-primary"><span class="fa fa-spinner"></span> Processing</button>
                    @endif
                  
                  </td>
                
                      <td class="text-center">

                        @if($frequisition->userId == auth()->user()->id)

                        @if($frequisition->status == 4)
                        <a  href="/procurement/{{$frequisition->id}}/editrequisition"  class='btn btn-info btn-sm' style='color: white;'>
                          <span class='fa fa-desktop'></span>
                          <span class='hidden-sm hidden-sm hidden-md'> Update </span>
                        </a>&nbsp;
                        <button type="button" class='btn btn-success btn-sm' data-toggle="modal" data-target="#historyModal{{ $frequisition->id }}" style='color: white;'>
                          <span class='fa fa-pencil'></span>
                          <span class='hidden-sm hidden-sm hidden-md'> Logs</span>
                       </button>&nbsp;
                       <a  href="/procurement/{{$frequisition->id}}/download" class='btn btn-primary btn-sm'  style='color: white;'>
                          <span class='fa fa-download'></span>
                          <span class='hidden-sm hidden-sm hidden-md'>Download</span>
                       </a>&nbsp;

                        @else
                          <a  href="/procurement/{{$frequisition->id}}/viewrequisition"  class='btn btn-info btn-sm' style='color: white;'>
                          <span class='fa fa-desktop'></span>
                          <span class='hidden-sm hidden-sm hidden-md'>View</span>
                        </a>&nbsp;
                        <button type="button" class='btn btn-success btn-sm' data-toggle="modal" data-target="#historyModal{{ $frequisition->id }}" style='color: white;'>
                          <span class='fa fa-pencil'></span>
                          <span class='hidden-sm hidden-sm hidden-md'>Logs</span>
                       </button>&nbsp;
                       <a  href="/procurement/{{$frequisition->id}}/download" class='btn btn-primary btn-sm'  style='color: white;'>
                          <span class='fa fa-download'></span>
                          <span class='hidden-sm hidden-sm hidden-md'>Download</span>
                       </a>&nbsp;

                       @endif                              

                       @else
                       <a  href="/procurement/{{$frequisition->id}}/viewrequisition" class='btn btn-info btn-sm' style='color: white;'>
                          <span class='fa fa-desktop'></span>
                          <span class='hidden-sm hidden-sm hidden-md'> View </span>
                       </a>&nbsp;
                       <button type="button" class='btn btn-success btn-sm' data-toggle="modal" data-target="#historyModal{{ $frequisition->id }}" style='color: white;'>
                          <span class='fa fa-pencil'></span>
                          <span class='hidden-sm hidden-sm hidden-md'>  Logs</span>
                       </button>&nbsp;
                       <a  href="/procurement/{{$frequisition->id}}/download" class='btn btn-primary btn-sm'  style='color: white;'>
                          <span class='fa fa-download'></span>
                          <span class='hidden-sm hidden-sm hidden-md'>Download</span>
                       </a>&nbsp;

                       @endif
                      </td>
                    </tr>
                    @endif
                    {{--  --}}
                    @endforeach
                  </tbody>
                </table>  
              </div>      
            </form>
          </div>

        </div>
      </div>
    </div>

    <!-- History Modals (moved outside the loop to avoid duplication) -->
    @foreach($frequisitions as $frequisition)
    @if(auth()->user()->id == $frequisition->userId || auth()->user()->userrole == $frequisition->approvedby)
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
                    <!-- Timeline 7 - Bootstrap Brain Component -->
                    <section class="bsb-timeline-7 py-3">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-12">
                                @if($frequisition->histories->isEmpty())
                                            <p>No history found for this requisition.</p>
                                        @else
                                    <ul class="timeline">
                                    @foreach($frequisition->histories as $history)

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
                                                        <div class="card-body p-xl-4"  style="position: relative;">
                                                        <h6 class="card-subtitle text-secondary mb-3" style="position: absolute; top: 10px; right: 10px;">{{ $loop->iteration }}</h6>
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
    @endforeach

    <!-- Filter Modal -->
    <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-primary modal-md" role="document">
        <form method="post" action="{{ route('requisition.filtered') }}" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" id="filterModalLabel">Filter Purchase Order Summary</h4>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label for="start_date">Date From</label>
                <input class="form-control" id="start_date" name="start_date" type="date">
              </div>
              <div class="form-group">
                <label for="end_date">Date To</label>
                <input class="form-control" id="end_date" name="end_date" type="date" >
              </div>
              <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" class="js-example-basic-single form-control"  style="width:100%;">     
                    <option value="">--Select Status--</option>       
                    <option value="2">Approved</option>       
                    <option value="3">Rejected</option>  
                    <option value="1">Pending</option>     
                </select>
              </div>
              <div class="form-group">
                <label for="vendor">Vendor</label>
                <select name="vendor" id="vendor" class="js-example-basic-single form-control"  style="width:100%;">   
                <option value="">--Select Vendor--</option> 
                @if(isset($vendors))
                @foreach($vendors as $vendor)               
                <option value="{{ $vendor->vendor }}"> {{ $vendor->vendor }}</option>
                  @endforeach
                @endif        
                </select>
              </div>             
            </div>
            <div class="modal-footer">
              <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
              <button class="btn btn-primary" type="submit">Filter Summary</button>
            </div>
          </div>
        </form>
        <!-- /.modal-content-->
      </div>
      <!-- /.modal-dialog-->
    </div>

  </div>
</div>

@endsection


<!-- Include jQuery and Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get both download buttons (the one above table and any others)
        const downloadButtons = document.querySelectorAll('button[type="submit"]');
        
        downloadButtons.forEach(function(downloadButton) {
            downloadButton.addEventListener('click', function(event) {
                // Only check for checkboxes if this is the download button (not filter button)
                if (downloadButton.innerHTML.includes('Download')) {
                    // Check if any checkboxes are checked
                    const checkboxes = document.querySelectorAll('input[name="requisition_ids[]"]:checked');
                    if (checkboxes.length === 0) {
                        event.preventDefault(); // Prevent form submission

                        // Display SweetAlert2 alert
                        Swal.fire({
                            icon: 'warning',
                            title: 'No Selection',
                            text: 'Please select at least one checkbox before downloading.',
                            confirmButtonText: 'Okay'
                        });
                    }
                }
            });
        });
    });
</script>
