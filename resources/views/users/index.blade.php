@extends('stack.layouts.admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> 
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/tutorials/timelines/timeline-7/assets/css/timeline-7.css">
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
    <div class="container-fluid"> <!-- Changed to container-fluid for full width -->
      <div class="row">
        <div class="col-12"> <!-- col-12 ensures full width within the container -->
          <div class="card">
          <div class="card-header">
            <strong>Users List</strong>
          
          </div>

            <div class="card-content collapse show">
              <div class="card-body card-dashboard">
             
                <table class="table table-striped table-bordered zero-configuration">
                  <thead>
                    <tr>
                  
              
                  <th class="text-center">Name</th>

                  <th class="text-center">Position</th>
                  <th class="text-center">Phone Number</th>
                  <th class="text-center">Email</th>                   
                  <th class="text-center">Status</th>
                  <th class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach($users as $user)
                    <tr>
                    
         
              <td class="text-center">{{$user->name}}</td>
              <td class="text-center">{{$user->position}}</td>
                  <td class="text-center">{{$user->phoneNumber}}</td>
                  <td class="text-center">{{$user->email}}</td>
                  <td class="text-center">
              
              @if($user->isActive == 1)
              <button type="button" class="btn btn-outline-success"><span class="fa fa-check-circle"></span> Active</button>
                @else
                <button type="button" class="btn btn-outline-danger"><span class="fa fa-check-circle"></span> InActive</button>
                @endif
              
              </td>
                  
                  <td class="text-center">                        
               
                    <a href="/users/{{$user->id}}/edit" class="btn btn-icon btn-info mr-1"><i class="fa fa-pencil"></i> Edit</a> 
                    <a href='#'class="btn btn-icon btn-danger mr-1"   onclick="
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
                      "><i class="fa fa-trash"></i> Delete</a> &nbsp;
                  </td>
                </tr>
                    </tr>
                    @endforeach
                    <!-- More rows here -->
                  </tbody>
                  <tfoot>
         
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> <!-- End of container-fluid -->
  </section>
</div>
@endsection
