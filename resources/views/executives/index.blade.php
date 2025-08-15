@extends('html.default')
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
            <strong>Executives</strong>
            <small>List</small>
                  <div class="d-flex justify-content-end mb-3" style="gap: 10px;">
             <a style="color:white;" href="/executives/create" class="btn btn-primary btn-sm pull-right"><i style="color:white;" class="icon-cloud-upload"></i> Add New Executive</a>
          </div>
            </div>

          <div class="card-body">
            <table class="table table-striped table-bordered zero-configuration">
              <thead>
                <tr>
                  <th>#</th>
                  <th> Executive Name</th>
                  <th> Username</th>
                  <th>Address</th>
                  <th class="text-center">Email</th>
                         
                  <th class="text-center">Status</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($executives as $executive)
                <tr>
                <td></td>
                  <td>{{$executive->name}}</td>
                  <td>{{$executive->userName}}</td>
                  <td>{{$executive->address}}</td>
                  <td>{{$executive->email}}</td>
                 
                  <td class="text-center">
                  @if($executive->IsActive == null)
                    <span class='badge badge-secondary'>Inactive</span>
                    @else
                    <span class='badge badge-success'>Active</span>
                    @endif              
                  </td>
                  <td class="text-center">
                  <a href='/executives/{{$executive->id}}/edit' class='btn btn-success btn-sm'>
                      <span class='fa fa-desktop'></span>
                      <span class='hidden-sm hidden-sm hidden-md'>Edit</span>
                    </a>&nbsp;
                    <a href='#' class='btn btn-danger btn-sm' style='color: white;' onclick="
                        event.preventDefault(); // Prevent the default link behavior
                        Swal.fire({
                            title: 'Delete Executive?',
                            text: 'You won\'t be able to undo this!',
                            icon: 'info', // Updated property for SweetAlert2
                            showCancelButton: true,
                            confirmButtonText: 'Continue',
                            cancelButtonText: 'Cancel'
                          }).then((result) => {
                            if (result.isConfirmed) {
                              // Redirect to the URL or perform an action
                              window.location.href = '/executives/{{$executive->id}}/delete'; // Replace with your actual URL
                            }
                          })
                      ">
                      <span class='fa fa-pencil'></span>
                      <span class='hidden-sm hidden-sm hidden-md'> Delete</span>
                    </a>&nbsp;
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
</div>

@endsection
