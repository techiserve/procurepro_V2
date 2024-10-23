@extends('stack.layouts.admin')

@section('content')
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <strong>Executives</strong>
            <small>List</small>
             <a style="color:white;" href="/executives/create" class="btn btn-primary btn-sm pull-right"><i style="color:white;" class="icon-cloud-upload"></i> Add New Executive</a>
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
