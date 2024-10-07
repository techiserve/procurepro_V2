@extends('coreui.layouts.admin')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
@section('content')
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <strong>Users</strong>
            <small>List</small>
             <a style="color:white;" href = '/users/create' class="btn btn-primary btn-sm pull-right"><i style="color:white;" class="icon-cloud-upload"></i> Add New User</a>
          </div>

          <div class="card-body">
            <table class="table table-responsive-sm table-bordered table-striped table-sm">
              <thead>
                <tr>
               
                  <th class="text-center">Status</th>
                  <th>Name</th>

                  <th>Position</th>
                  <th>Phone Number</th>
                  <th class="text-center">Email</th>                   
                 
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($users as $user)
                <tr>
           
                <td class="text-center">
              
              @if($user->isActive == 1)
              <button type="button" class="btn btn-outline-success"><span class="fa fa-check-circle"></span> Active</button>
                @else
                <button type="button" class="btn btn-outline-danger"><span class="fa fa-check-circle"></span> InActive</button>
                @endif
              
              </td>
                <td>
                            <div class="text-nowrap">{{$user->name}}</div>
                            <div class="small text-body-secondary text-nowrap"> @if($user->isActive == null)<span>InActive</span> @else <span>Active</span> @endif | {{ $user->created_at->format('M j, Y')}}</div>
                          </td>
             
                  <td>{{$user->position}}</td>
                  <td>{{$user->phoneNumber}}</td>
                  <td>{{$user->email}}</td>
                 
               
                  <td class="text-center">                
                    <a href='/users/{{$user->id}}/edit' class='btn btn-info btn-sm' style='color: white;'>
                      <span class='fa fa-pencil'></span>
                      <span class='hidden-sm hidden-sm hidden-md'> Edit</span>
                    </a>
                    &nbsp;
                    <a href='#' class='btn btn-danger btn-sm'   onclick="
                        event.preventDefault(); // Prevent the default link behavior
                        Swal.fire({
                            title: 'Delete User?',
                            text: 'You won\'t be able to undo this!',
                            icon: 'info', // Updated property for SweetAlert2
                            showCancelButton: true,
                            confirmButtonText: 'Continue',
                            cancelButtonText: 'Cancel'
                          }).then((result) => {
                            if (result.isConfirmed) {
                              // Redirect to the URL or perform an action
                              window.location.href = '/users/{{$user->id}}/delete'; // Replace with your actual URL
                            }
                          })
                      "
                    >
                      <span class='fa fa-trash'></span>
                      <span class='hidden-sm hidden-sm hidden-md'>Delete</span>
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
