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
            <strong>Companies</strong>
          
             <a style="color:white;" href="/companies/create" class="btn btn-primary btn-md pull-right"><i style="color:white;" class="icon-cloud-upload"></i> Add New Company</a>
          </div>

          <div class="card-body">
            <table class="table table-striped table-bordered zero-configuration">
              <thead>
                <tr>
               
                  <th> Company Name</th>
                  <th> Domain</th>
                  <th>Contact Person</th>
                  <th class="text-center">Email</th>
                         
                  <th class="text-center">Status</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($companies as $company)
                <tr>
              
                  <td>{{$company->name}}</td>
                  <td>{{$company->domain}}</td>
                  <td>{{$company->contactPerson}}</td>
                  <td>{{$company->email}}</td>
                 
                  <td class="text-center">
              
                  @if($company->IsActive == null)
                    <span class='badge badge-secondary'>Inactive</span>
                    @else
                    <span class='badge badge-success'>Active</span>
                    @endif
                  
                  </td>
                  <td class="text-center">
                  <a href='/company/{{$company->id}}/edit' class='btn btn-success btn-sm'>
                      <span class='fa fa-desktop'></span>
                      <span class='hidden-sm hidden-sm hidden-md'>Edit</span>
                    </a>&nbsp;
                    <a href='#' class='btn btn-danger btn-sm' style='color: white;' onclick="
                        event.preventDefault(); // Prevent the default link behavior
                        Swal.fire({
                            title: 'Delete Company?',
                            text: 'You won\'t be able to undo this!',
                            icon: 'info', // Updated property for SweetAlert2
                            showCancelButton: true,
                            confirmButtonText: 'Continue',
                            cancelButtonText: 'Cancel'
                          }).then((result) => {
                            if (result.isConfirmed) {
                              // Redirect to the URL or perform an action
                              window.location.href = '/company/{{$company->id}}/delete'; // Replace with your actual URL
                            }
                          })
                      ">
                      <span class='fa fa-pencil'></span>
                      <span class='hidden-sm hidden-sm hidden-md'> Delete</span>
                    </a>
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
