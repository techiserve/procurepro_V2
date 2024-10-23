@extends('stack.layouts.admin')

@section('content')
<div class="content-header row">
  <div class="content-header-left col-md-6 col-12 mb-2">
    <h3 class="content-header-title mb-0">Users List</h3>
    <div class="row breadcrumbs-top">
      <div class="breadcrumb-wrapper col-12">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"></li>
          <li class="breadcrumb-item active"></li>
        </ol>
      </div>
    </div>
  </div>

  <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
    <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
      <a class="btn btn-outline-primary" href="/users/create"><i class="feather icon-pie-chart"></i> Create User</a>
    </div>
  </div>
</div>

<div class="content-body">
  <section id="configuration">
    <div class="container-fluid"> <!-- Changed to container-fluid for full width -->
      <div class="row">
        <div class="col-12"> <!-- col-12 ensures full width within the container -->
          <div class="card">
         
            <div class="card-content collapse show">
              <div class="card-body card-dashboard">
             
                <table class="table table-striped table-bordered zero-configuration">
                  <thead>
                    <tr>
                  
              
                  <th>Name</th>

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
                    <a href='#'class="btn btn-icon btn-danger mr-1"><i class="fa fa-trash"></i> Delete</a> &nbsp;
                  </td>
                </tr>
                    </tr>
                    @endforeach
                    <!-- More rows here -->
                  </tbody>
                  <tfoot>
                    <tr>
                    
                    <th class="text-center">Status</th>
                  <th>Name</th>

                  <th>Position</th>
                  <th>Phone Number</th>
                  <th class="text-center">Email</th>                   
                 
                  <th class="text-center">Action</th>
                    </tr>
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
