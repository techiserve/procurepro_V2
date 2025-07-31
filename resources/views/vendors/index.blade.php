@extends('stack.layouts.admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> 
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/tutorials/timelines/timeline-7/assets/css/timeline-7.css">

<!-- Add DataTables CSS and JS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

@section('content')
<div class="content-header row">
  <div class="content-header-left col-md-6 col-12 mb-2">
    <div class="row breadcrumbs-top">
      <div class="breadcrumb-wrapper col-12">
      </div>
    </div>
  </div>
  <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
    <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
    </div>
  </div>
</div>

<div class="content-body">
  <section id="configuration">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <strong>Vendors List</strong>
              <a href="/procurement/createVendor" class="btn btn-md btn-success pull-right">
                <i class="fa fa-plus"></i> Add Vendor
              </a>
            </div>

            <div class="card-content collapse show">
              <div class="card-body card-dashboard">
                @if (session('success'))
                  <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="table-responsive">
                  <table class="table table-striped table-bordered file-export" >
                    <thead style="background-color:#f4f4f4;">
                      <tr>
                        <th data-field="id" class="text-center">Name</th>
                        <th data-field="grower_name" class="text-center">Type</th>
                        <th data-field="grower_number" class="text-center">Contact</th>
                        <th data-field="province" class="text-center">Finance Manager</th>
                        <th data-field="grower_type" class="text-center">Bank</th>
                        <th data-field="grower_size" class="text-center">Account #</th>
                        <th  class="text-center">Status</th>
                        <th class="text-center">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($vendors as $vendor)
                        @php
                          $statusLabels = [
                              1 => ['text' => 'Incomplete', 'class' => 'badge-secondary'],
                              2 => ['text' => 'Pending', 'class' => 'badge-warning'],
                              3 => ['text' => 'Approved', 'class' => 'badge-success'],
                              4 => ['text' => 'Returned', 'class' => 'badge-info'],
                              5 => ['text' => 'Rejected', 'class' => 'badge-danger'],
                          ];
                          $currentStatus = $statusLabels[$vendor->status] ?? ['text' => 'Unknown', 'class' => 'badge-dark'];
                        @endphp

                        <tr>
                          <td class="text-center">{{ $vendor->name }}</td>
                          <td class="text-center">{{ $vendor->type }}</td>
                          <td class="text-center">{{ $vendor->contact_no_1 }}</td>
                          <td class="text-center">
                            @foreach ($users as $user)   
                              @if ($user->id == $vendor->finance_manager)
                                {{ $user->name }}
                                @break
                              @endif   
                            @endforeach
                          </td>
                          <td class="text-center">{{ $vendor->bank_name }}</td>
                          <td class="text-center">{{ $vendor->account_number }}</td>
                          <td class="text-center">
                            <span class="badge {{ $currentStatus['class'] }}">
                              {{ $currentStatus['text'] }}
                            </span>
                          </td>
                          <td class="text-center">
                            @if($vendor->status != 5)                
                            <a href="/vendors/edit/{{$vendor->id}}" class="btn btn-icon btn-info mr-1">
                              <i class="fa fa-pencil"></i> Edit
                            </a>
                            <a href='#' class="btn btn-icon btn-danger mr-1" style='color: white;' onclick="
                              event.preventDefault();
                              Swal.fire({
                                  title: 'Delete Vendor?',
                                  text: 'You won\'t be able to undo this!',
                                  icon: 'info',
                                  showCancelButton: true,
                                  confirmButtonText: 'Continue',
                                  cancelButtonText: 'Cancel'
                                }).then((result) => {
                                  if (result.isConfirmed) {
                                    window.location.href = '/vendors/delete/{{$vendor->id}}';
                                  }
                                })
                            ">
                              <span class='fa fa-trash'></span>
                              <span class='hidden-sm hidden-md'> Delete</span>
                            </a>
                            @endif
                             <a href="#" data-toggle="modal" data-target="#historyModal{{ $vendor->id }}"  class="btn btn-icon btn-success mr-1">
                              <i class="fa fa-pencil"></i> Logs
                            </a>

                            <!-- Modal Structure -->
                <div class="modal fade" id="historyModal{{ $vendor->id }}" tabindex="-1" role="dialog" aria-labelledby="historyModalLabel{{ $vendor->id }}" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="timelineModalLabel">Vendor Request Logs</h5>
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
                            @if($vendor->history->isEmpty())
                                        <p>No history found for this requisition.</p>
                                    @else
                                <ul class="timeline">
                                @foreach($vendor->history as $history)

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
                                                    <h6 class="card-subtitle text-secondary mb-3" style="position: absolute; top: 10; right: 10;">{{ $loop->iteration }}</h6>
                                                        <h2 class="card-title mb-2">{{$history->doneby}}</h2>
                                                      
                                                        <p class="card-text m-0">{{$history->reason}}</p>
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
                          </td>
                        </tr>
                      @empty
                        <tr>
                          <td colspan="8" class="text-center">No vendors found.</td>
                        </tr>
                      @endforelse
                    </tbody>
                 
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<script>
$(document).ready(function() {
    // Initialize DataTable if not already initialized by the layout
    if (!$.fn.DataTable.isDataTable('#vendorsTable')) {
        $('#vendorsTable').DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "paging": true,
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "language": {
                "search": "Search vendors:",
                "lengthMenu": "Show _MENU_ vendors per page",
                "info": "Showing _START_ to _END_ of _TOTAL_ vendors",
                "infoEmpty": "Showing 0 to 0 of 0 vendors",
                "infoFiltered": "(filtered from _MAX_ total vendors)"
            }
        });
    }
    
    // Alternative: If your layout already initializes tables with .zero-configuration class
    // You can just ensure the class is properly applied and remove the above initialization
});
</script>
@endsection