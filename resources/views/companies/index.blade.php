@extends('stack.layouts.admin')

@section('content')
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <strong>Companies</strong>
            <small>List</small>
             <a style="color:white;" href="/companies/create" class="btn btn-primary btn-sm pull-right"><i style="color:white;" class="icon-cloud-upload"></i> Add New Company</a>
          </div>

          <div class="card-body">
            <table class="table table-striped table-bordered zero-configuration">
              <thead>
                <tr>
                  <th>#</th>
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
                <td></td>
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
