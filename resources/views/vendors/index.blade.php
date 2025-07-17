@extends('stack.layouts.admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> 
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/tutorials/timelines/timeline-7/assets/css/timeline-7.css">
@section('content')

<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <strong>Vendors List</strong>
            <a href="/procurement/createVendor" class="btn btn-md btn-success pull-right">
              <i class="fa fa-plus"></i> Add Vendor
            </a>
          </div>

          <div class="card-body">
            @if (session('success'))
              <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
              <table class="table table-bordered table-striped">
                <thead style="background-color:#f4f4f4;">
                  <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Contact</th>
                    <th>Finance Manager</th>
                    <th>Bank</th>
                    <th>Account #</th>
                    <th>Active</th>
                    <th>Actions</th>
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
                      <td>{{ $vendor->name }}</td>
                      <td>{{ $vendor->type }}</td>
                      <td>{{ $vendor->contact_no_1 }}</td>
                        @foreach ($users as $user)   
                      @if ($user->id == $vendor->finance_manager )
                     <td>{{ $user->name }}</td>
                      @endif   
                      @endforeach
                      <td>{{ $vendor->bank_name }}</td>
                      <td>{{ $vendor->account_number }}</td>
                      <td>
                      <span class="badge {{ $currentStatus['class'] }}">
                     {{ $currentStatus['text'] }}
                        </span>
                      </td>
                      <td>                
                        <a href="/vendors/edit/{{$vendor->id}}" class="btn btn-icon btn-info mr-1"><i class="fa fa-pencil"></i>Edit
                        </a>
                           <a href='#'  class="btn btn-icon btn-danger mr-1"style='color: white;' onclick="
                        event.preventDefault(); // Prevent the default link behavior
                        Swal.fire({
                            title: 'Delete Vendor?',
                            text: 'You won\'t be able to undo this!',
                            icon: 'info', // Updated property for SweetAlert2
                            showCancelButton: true,
                            confirmButtonText: 'Continue',
                            cancelButtonText: 'Cancel'
                          }).then((result) => {
                            if (result.isConfirmed) {
                              // Redirect to the URL or perform an action
                              window.location.href = '/vendors/delete/{{$vendor->id}}'; // Replace with your actual URL
                            }
                          })
                      ">
                      <span class='fa fa-trash'></span>
                      <span class='hidden-sm hidden-sm hidden-md'> Delete</span>
                    </a>&nbsp;
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
@endsection
