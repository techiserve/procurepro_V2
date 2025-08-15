@extends('html.default')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/tutorials/timelines/timeline-7/assets/css/timeline-7.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="https://unpkg.com/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/tutorials/timelines/timeline-7/assets/css/timeline-7.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('content')
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <strong>Manage Purchase Order</strong>
          </div>

          <div class="card-body">
            
          <form action="{{ route('purchaseorder.release') }}" method="POST">
          @csrf <!-- Always include CSRF token for security -->
          <div class="d-flex justify-content-end mb-3" style="gap: 10px;">
            <button type="submit" name="action" value="Complete_Selected_Orders" class="btn btn-primary btn-sm" style="padding: 10px 20px; font-size: 16px; min-width: 100px;">
              <i class="fa fa-filter"></i> Complete Selected Orders
            </button>
            <button type="submit" name="action" value="Release_Selected_Orders" class="btn btn-success btn-sm" style="padding: 10px 20px; font-size: 16px; min-width: 100px;">
              <i class="fa fa-filter"></i> Release Purchase Orders
            </button>
          </div>
            <div style="overflow-x:auto;">
              <table class="table table-striped table-bordered zero-configuration" >
              <thead>
                <tr>
                <th><input type="checkbox" id="selectAll"></th> <!-- Select All Checkbox -->
                <th>Requisition #</th>   
                  @php
                    $hiddenFields = []; // No hidden fields now

                    $customLabels = [
                        'paymentmethod' => 'Payment Method',
                        'payment_method' => 'Payment Method',
                        'invoiceamount' => 'Invoice Amount',
                        // Add more mappings as needed
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
                <th>Bank</th>   
                <th>Account</th>   
                <th>Approved By</th>   
                <th>Status</th>         
                <th class="text-center" style="width: 180px;">Action</th>    
                </tr>
              </thead>
              <tbody>
                 @foreach($fpurchaseorders as $fpurchaseorder)
                <tr>
                  @php  $active = $fpurchaseorder->status; @endphp
                <td><input type="checkbox" name="selected_items[]" value="{{ $fpurchaseorder->id }}" @if($active != '2') disabled @endif></td>
                    <td>{{ $fpurchaseorder->requisitionNumber }}</td>
                     @php
                        $hiddenFields = [''];
                        // Normalize requisition data to lowercase keys for safe access
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
                                {{-- Map department ID to department name --}}
                                {{ $departments->firstWhere('id', $fpurchaseorder->department)->name ?? 'Unknown Department' }}
                            @else
                                {{ $normalizedRequisition[$normalizedField] ?? '' }}
                            @endif
                        </td>
                    @endforeach   
                
                 <td class="text-center">{{$fpurchaseorder->bankAccountName}}</td>
                 <td class="text-center">{{$fpurchaseorder->bankAccountNumber}}</td>
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
          
                  <td class="text-center" style="width: 180px;">
                  @if($fpurchaseorder->status == 0 OR $fpurchaseorder->status == 4)
                
                    <button type="button" class='btn btn-success btn-sm' data-bs-toggle="modal" data-bs-target="#historyModal{{ $fpurchaseorder->id }}" style='color: white;'>
                      <span class='fa fa-pencil'></span>
                      <span class='hidden-sm hidden-sm hidden-md'>  Logs</span>
                    </button>&nbsp;

                    @else
                  
                    <button type="button" class='btn btn-success btn-sm' data-bs-toggle="modal" data-bs-target="#historyModal{{ $fpurchaseorder->id }}" style='color: white;'>
                      <span class='fa fa-pencil'></span>
                      <span class='hidden-sm hidden-sm hidden-md'>  Logs</span>
                    </button>&nbsp;               

                    @endif
                        
                     <button type="button" class='btn btn-info btn-sm' data-bs-toggle="modal" data-bs-target="#pop{{ $fpurchaseorder->id }}" style='color: white;'>
                      <span class='fa fa-download'></span>
                      <span class='hidden-sm hidden-sm hidden-md'> Upload POP</span>
                     </button>&nbsp;

                     <a  href="/procurement/{{$fpurchaseorder->id}}/paymentRelease" class='btn btn-secondary btn-sm' style='color: white;'>
                      <span class='fa fa-pencil'></span>
                      <span class='hidden-sm hidden-sm hidden-md'>Payment Release</span>
                     </a>&nbsp;  

                     <a  href="/procurement/{{$fpurchaseorder->frequisition_id}}/view" class='btn btn-info btn-sm' style='color: white;'>
                      <span class='fa fa-desktop'></span>
                      <span class='hidden-sm hidden-sm hidden-md'>View</span>
                     </a>&nbsp;  

                     <button type="button" class='btn btn-success btn-sm' data-bs-toggle="modal" data-bs-target="#viewdocuments{{ $fpurchaseorder->id }}" style='color: white;'>
                      <span class='fa fa-download'></span>
                      <span class='hidden-sm hidden-sm hidden-md'>View Documents</span>
                     </button>&nbsp;  
                     

                     
               {{-- View Documents Modal --}}
  <div class="modal fade" id="viewdocuments{{ $fpurchaseorder->id }}" tabindex="-1" aria-labelledby="viewdocuments{{ $fpurchaseorder->id }}Label" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h4 class="modal-title" id="viewdocuments{{ $fpurchaseorder->id }}Label"><i class="fa fa-envelope"></i> View Documents</h4>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form method="POST" action="" enctype="multipart/form-data">
        @csrf
        @method('put')

        <div class="modal-body" style="font-size: 14px;">
          @php
            // Assuming $documents is an array of up to 4 filenames passed from the controller
          $docs = [
                  'Quotation' => $fpurchaseorder->quotation ?? null,
                  'Invoice'   => $fpurchaseorder->invoice ?? null,
                  'POP'       => $fpurchaseorder->pop ?? null,
                  'Job Card'  => $fpurchaseorder->jobcard ?? null,
                ];

          @endphp

          @if(array_filter($docs))
            <div class="mt-4">
              <h5>View Documents</h5>
              <table class="table table-sm table-bordered table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Document Name</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                 @php $counter = 1; @endphp
                  @foreach($docs as $label => $file)
                    @if($file)
                      <tr>
                        <td>{{ $counter++ }}</td>
                        <td>{{ $label }}</td>
                        <td>
                          <a href="{{ asset('storage/uploads/' . $file) }}" target="_blank" class="btn btn-sm btn-info">
                            <i class="fa fa-eye"></i> View
                          </a>
                        </td>
                      </tr>
                    @endif
                  @endforeach
                </tbody>
              </table>
            </div>
          @else
            <div class="alert alert-info">
              <i class="fa fa-info-circle"></i> No documents available for this purchase order.
            </div>
          @endif

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">
            <i class="fa fa-upload"></i> Upload
          </button>
        </div>

      </form>
    </div>
  </div>
</div>


             <!-- History Modal Structure -->
                   <div class="modal fade" id="historyModal{{ $fpurchaseorder->id }}" tabindex="-1" aria-labelledby="historyModal{{ $fpurchaseorder->id }}Label" aria-hidden="true">
          <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="historyModal{{ $fpurchaseorder->id }}Label">Requisition Logs</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Timeline 7 - Bootstrap Brain Component -->
                <section class="bsb-timeline-7 py-3">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-12">
                            @if($fpurchaseorder->histories->isEmpty())
                                        <div class="alert alert-info">
                                          <i class="fa fa-info-circle"></i> No history found for this requisition.
                                        </div>
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
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


         {{-- POP Upload Modal --}}
            <div class="modal fade" id="pop{{ $fpurchaseorder->id }}" tabindex="-1" aria-labelledby="pop{{ $fpurchaseorder->id }}Label" aria-hidden="true">
            	<div class="modal-dialog modal-md">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title" id="pop{{ $fpurchaseorder->id }}Label"><i class="fa fa-envelope"></i> Upload Proof of Payment</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  
                  <form method="POST" action="/procurement/{{$fpurchaseorder->id}}/pop" enctype="multipart/form-data">
                   @csrf
                   @method('put')
                   
                  <div class="modal-body" style="font-size: 14px;">							
										<div class="form-group mb-3">
											<label for="pop{{ $fpurchaseorder->id }}" class="form-label">Upload document</label>
											<input type="file" name="pop" id="pop{{ $fpurchaseorder->id }}" class="form-control" maxlength="150" required/>
										</div>
                  </div>

                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
										<button type="submit" class="btn btn-primary"><span class='fa fa-upload'></span> Upload</button>
                  </div>
                  
                  </form>
                </div>
            </div>
            </div>
                   
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
           
            </form>

          </div>

        </div>
      </div>
    </div>

  </div>
</div>
@endsection

@section('scripts')
<!-- Bootstrap JS Bundle -->
<script src="https://unpkg.com/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select All functionality
    const selectAllCheckbox = document.getElementById('selectAll');
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('input[name="selected_items[]"]');
            checkboxes.forEach(checkbox => {
                if (!checkbox.disabled) {
                    checkbox.checked = this.checked;
                }
            });
        });
    }

    // Modal event listeners for debugging
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        modal.addEventListener('show.bs.modal', function(e) {
            console.log('Modal opening:', e.target.id);
        });
        
        modal.addEventListener('shown.bs.modal', function(e) {
            console.log('Modal opened:', e.target.id);
        });

        modal.addEventListener('hide.bs.modal', function(e) {
            console.log('Modal closing:', e.target.id);
        });

        modal.addEventListener('hidden.bs.modal', function(e) {
            console.log('Modal closed:', e.target.id);
        });
    });

    // Handle form validation for POP upload
    const popForms = document.querySelectorAll('form[action*="/pop"]');
    popForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const fileInput = form.querySelector('input[type="file"]');
            if (!fileInput.value) {
                e.preventDefault();
                alert('Please select a file to upload.');
                return false;
            }
        });
    });
});
</script>
@endsection