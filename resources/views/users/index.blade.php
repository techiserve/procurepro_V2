@extends('coreui.layouts.admin')

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
                  <th>#</th>
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
                <td></td>
                <td class="text-center">
              
              @if($user->isActive == null)
              <div class="avatar avatar-md"><img class="avatar-img" src="{{ asset('/coreui/img/avatars/fnbbb.png') }}" alt="user@email.com"><span class="avatar-status bg-danger"></span></div>
                @else
                <!-- <span class='badge badge-success'>Active</span> -->
                <div class="avatar avatar-md"><img class="avatar-img" src="{{ asset('/coreui/img/avatars/6.jpg') }}" alt="user@email.com"><span class="avatar-status bg-success"></span></div>
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
                  <a href='' class='btn btn-success btn-sm'>
                      <span class='fa fa-desktop'></span>
                      <span class='hidden-sm hidden-sm hidden-md'> View</span>
                    </a>&nbsp;
                    <a href='' class='btn btn-info btn-sm' style='color: white;'>
                      <span class='fa fa-pencil'></span>
                      <span class='hidden-sm hidden-sm hidden-md'> Edit</span>
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
